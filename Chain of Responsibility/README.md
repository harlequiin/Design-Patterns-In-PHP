## Chain of Responsibility

Decouples the sender form receiver by giving more than one object a chance to
handle the request. Chain the receiving objects and pass requests along the
chain until one of the objects in the chain handles it.

#### Use the Chain of Responsibility pattern when:

- more than one object may handle a request, and the handler isn't known previously. 
- set of objects that can handle a request should be specified dynamically.
  (The handler is determined automatically).

### General Structure

![UML diagram of the Chain of Responsibility pattern][1]

#### Participants:
- **Handler**: defines an interface for handling requests. You may optionally
  declare a method for setting the next handler in chain (we choose to do it in
  _BaseHandler_ here).
- **BaseHandler**: is an optional class where you can put the boilerplate code
  that's common to all handler classes. Here we define a field for referencing
  the next handler object in chain. There are various ways how you can build
  chains - you may use a setter of the previous handler, as we do here, you
  may declare the next handler in the constructor etc - it's all up to you and
  your needs.  
  This class may also implement some default handling behavior - here it passes
  the execution to the next handler after checking for its existence.
- **ConcreteHandlerA**, **ConcreteHandlerB**: they do the actual processing of
  the requests.  
  After receiving a request each handler decides whether to process it and/or
  pass it further down the chain. There are various conventions on how to go
  about passing the request further - a canonical CoR approach is to pass the
  request _only if_ the handler _can't_ process it. Another common approach
  (particularly in back-end web development) is to pass the request further down the
  chain (of _middlewares_) _only if_ the handler _can_ process it - 
  if it can't - some sort of error gets thrown and/or an error page displayed
  to the user.

### Our Example

![Our example UML diagram][2]

- **RequestHandlerInterface** together with **MiddlewareInterface**
  act as our _Handlers_. The reason we have two different interfaces is that
  PSR-15 standard differentiates between these two even though their roles can
  be similar - both participate in handling/processing a _Request_.
  _MiddlewareInterface_ is the one that represents our composed _Handlers_.
- **RequestHandler** is our "main" _ConcreteHandler_. It composes a middleware stack,
  sends _Requests_ to it by popping them off the stack one by one. If there are
  no middlewares left, it sends the _Request_ to a fallback handler.
- **NotFoundHandler** acts as the fallback handler. It's a **ConcreteHandler**
  of a special case - it normally doesn't participate in the _Request_
  processing - however, if the _Request_ isn't handled by our primary
  _RequestHandler_ and middleware stack - it acts as a catch-all handler which
  constructs and returns a "not found" _Response_. We could've easily done
  without it and let the main _RequestHandler_ handle the unsuccessful
  requests, but I chose to include this because the
  [PSR-15 documentation](https://www.php-fig.org/psr/psr-15/meta/#63-example-interface-interactions) includes this in their example.
- **AbstractMiddleware** acts as a _BaseHandler_ for all our concrete middlewares,
  provides default _process_ method implementation that simply passes the
  _Request_ to the _RequestHandler_. All our concrete middlewares extend this.
- **AuthorizationMiddleware**, **CacheMiddleware**, **RouterMiddleware** act as
  our _ConcreteHandlers_ for the middleware stack.

PSR-15 standard doesn't define a single way of composing and chaining
handlers/middlewares - you can do this like in our example, you can copy the
canonical form, you may use [decoration-based](https://www.php-fig.org/psr/psr-15/meta/#decoration-based-request-handler) request handler, etc.
This is where flexibility in applying the desing patterns comes in.

[1]: https://i.ibb.co/6Hwsj18/Chain-of-Responsibility.png
[2]: https://i.ibb.co/G31Vhd0/Chain-of-Responsibility-Example.png 
