## Adapter

Converts the interface of a class into an interface the client understands.
Adapter lets classes work together that couldn't otherwise because of
incompatible interfaces.  
Also known as **Wrapper**

#### Use the Adapter pattern when:

- you want to use an existing class and its interface doesn't match the one you must
  have. 
- you want to have a reusable class that cooperates with potentially
  incompatible classes.
- you want to reuse a hierarchy of subclasses that lack some common
  functionality that can't be added in a superclass (subclassing each class
  in the hierarchy would break DRY prinicple). If all the subclasses have
  a common interface, you can use an object adapter.

### General Structure

In general, we can implement the _Adapter_ pattern in 2 ways:
- as an _object adapter_
- as a _class adapter_

#### Object Adapter

![UML diagram of the Object Adapter pattern][1]

An object adapter relies on object composition.
Works with the adaptee itself and all of its potential subclasses.

#### Class Adapter

![UML diagram of the Class Adapter pattern][2]

A class adapter uses inheritance to adapt one interface to another.  
No additional object pointer indirection is needed to get to the adaptee. We
use _super_ calls to a parent class.  
Won't work when we want to adapt a class and all of it's subclasses.

#### Participants:

- **Target**: defines the domain-specific interface that the _Client_ uses and
  other classes must follow in order to be able to collaborate with the
  _Client_ code.
- **Client**: implements some domain logic that, among other things, collaborates
  with objects implementing the _Target_ interface.
- **Adaptee**: defines an existing interface that needs adapting. This could be
  some useful 3rd party service class or a legacy class that your code needs.
- **Adapter**: adapts the _Adaptee_ to the _Target_ interface.

### Our Example

![Our example UML diagram][3]

- **MessengerInterface** acts as the _Target_ interface in our example. The _Client_
  recognizes and uses it.  
- **IncompatibleMessenger** is our 3rd party (could also be legacy etc.) class
  that doesn't implement the **MessengerInterface** and needs adapting.
- **IncompatibleMessengerAdapter** acts as the _Adapter_ (more specifically -
  an _object adapter_) which composes our incompatible class. Internally, it
  delegates all the action to the adapted messenger and returns its result.  
- **App** is our _Client_ and makes use of the _IncompatibleMessengerAdapter_
  through the _MessengerInterface_.  

[1]: https://i.ibb.co/MfK5sqV/Adapter-Object.png
[2]: https://i.ibb.co/gwxXzVj/Adapter-Class.png
[3]: https://i.ibb.co/986vSZB/Adapter-example.png
