# RabbitMQ

Hi, Let's learning RabbitMQ by PHP

## 1. 简单的发布与订阅

```shell

php exapmle/RabbitMQ/Worker.php

php exapmle/RabbitMQ/Task.php

```
just do it


## FAQ

* 消息确认

> 完成任务可能需要几秒钟。你可能遇到如果一个消费者开始一个长期的任务，并且只完成了部分任务，那么会发生什么？。我们目前的代码，一旦RabbitMQ发送一个消息给客户立即标记为删除。在这种情况下，如果您中止一个消费者，我们将丢失它正在处理的消息。我们还将丢失发送给该消费者所有的尚未处理的消息。

>  如果我们不想失去任何任务。如果一个消费者意外中止了，我们希望把任务交给另一个消费者。
  
>  为了确保消息不会丢失，RabbitMQ支持消息确认。ACK（nowledgement）消费者返回的结果告诉RabbitMQ有一条消息收到，你可以自由可控的删除他
  
>  如果一个消费者中止了（其通道关闭，连接被关闭，或TCP连接丢失）不发送ACK，RabbitMQ将会理解这个消息并没有完全处理，将它重新加入队列。如果有其他用户同时在线，它就会快速地传递到另一个消费者。这样，即使意外中止了，也可以确保没有丢失信息。
  
  
   
>  没有任何消息超时；当这个消费者中止了，RabbitMQ将会重新分配消息时。即使处理消息花费很长很长时间也很好。

消息确认是默认关闭。可通过设置的第四个参数basic_consume设置为false（true意味着没有ACK）和从消费者发送合适的确认，一旦我们完成一个任务。

```php

$callback = function($msg){
  echo " [x] Received ", $msg->body, "\n";
  sleep(substr_count($msg->body, '.'));
  echo " [x] Done", "\n";
  $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

MQ::channel()->basic_consume('task_queue', '', false, false, false, false, $callback);

```

* 忘记确认


丢失ACK确认是一个常见的错误。这是一个容易犯的错误，但后果很严重。当你的客户退出，消息会被重新分配（这可能看起来像是随机的分配），RabbitMQ将会消耗更多的内存，它不会释放任何延迟确认消息。

为了调试这种错误，你可以使用rabbitmqctl打印messages_unacknowledged字段：

```shell

rabbitmqctl list_queues name messages_ready messages_unacknowledged

```

* 消息持久化(Message durability)

当RabbitMQ退出或崩溃了，会丢失队列和消息除非你不要。要确保消息不会丢失，需要两件事：我们需要将队列和消息都标记为持久的。
 
首先，我们需要确保RabbitMQ永远不会丢失队列。为了做到这一点，我们需要声明它是持久的。为此我们通过queue_declare作为第三参数为true：

```php

MQ::channel()->queue_declare('hello', false, true, false, false);

```

虽然这个命令本身是正确的，但它在我们当前的设置中不起作用。这是因为我们已经定义了一个名为hello的队列，该队列不持久。

RabbitMQ不允许你重新定义现有队列用不同的参数，这样做将返回一个错误。但有一个快速的解决方法-让我们声明一个名称不同的队列，例如task_queue:

```php

MQ::channel()->queue_declare('task_queue', false, true, false, false);

```

需要应用到生产者和消费者代码中设置为true。

在这一点上，我们可以确保即使RabbitMQ重启了，task_queue队列不会丢失。

现在我们要标记我们的消息持续<通过设置delivery_mode = 2消息属性，amqpmessage作为属性数组的一部分。

```php

$msg = new AMQPMessage($data, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT) );

```

!* 将消息标记为持久性不能完全保证消息不会丢失。虽然它告诉RabbitMQ保存信息到磁盘上，还有一个短的时间窗口时，RabbitMQ 已经接受信息并没有保存它。另外，RabbitMQ不做fsync(2)每一个消息--它可能只是保存到缓存并没有真正写入到磁盘。持久性保证不强，但对于我们的简单任务队列来说已经足够了。如果你需要更强的保证，那么你可以使用消费者确认。

* 公平调度

您可能已经注意到，调度仍然不完全按照我们的要求工作。例如，在一个有两个消费者的情况下，当所有的奇数信息都很重，甚至很轻的消息，一个消费者会一直忙，而另一个消费者几乎不做任何工作。

RabbitMQ不知道发生了什么事，仍将均匀消息发送。

这是因为RabbitMQ只是调度消息时，消息进入队列。当存在未确认的消息时。它只是盲目的分发n-th条消息给n-th个消费者。


为了改变这个分配方式，我们可以调用basic_qos方法，设置参数prefetch_count = 1。这告诉RabbitMQ不要在一个时间给一个消费者多个消息。或者，换句话说，在处理和确认以前的消息之前，不要向消费者发送新消息。相反，它将发送给下一个仍然不忙的消费者。

```php

MQ::channel()->basic_qos(null, 1, null);

```




