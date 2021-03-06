## Facade

Provides a single unified interface for a set of objects in a subsystem.
**Facade** is a higher-level interface that makes the subsystem easier to use.  
You can think of a **Facade** as a simplicity adapter for a complex subsystem.

#### Use the Facade pattern when:

- you want to provide a simple interface to a complex subsystem. As subsystems
  evolve they gradually become more complex. Most of the patterns we explore
  here introduce a lot of smaller classes - the code gets more modular and
  subsystems - easier to reuse, howeve, it also complicates the communication
  between a client and a susbsystem. A _Facade_ provides a simplified gateway
  for a complex susbsystem.
- you want to layer your subsystems. _Facade_ introduces an entry point to each
  level of a subsystem. Layer then can communicate with each other via those
  _Facades_.

### General Structure

![UML diagram of the Facade pattern][1]

#### Participants:
- **Facade**: delegates _Client_ requests to the appropriate subsystem objects. It
  knows where to direct the _Client_ requests and how to coordinate all the
  subsystem's objects in order to fullfill that request. May additionally manage the
  lifecycle of the subsystem's objects.
- **Additional Facade**: may be split out from the _Facade_ in order to avoid
  making it into yet another complex structure or a
  [God Object](https://en.wikipedia.org/wiki/God_object).
  It can be used by _Clients_ and other _Facades_ alike.
- **Subsystem classes**: implement subsystem functionality. They handle all the work
  delegated to by the _Facade_ object. They don't know and hold no references to
  the _Facade_ object - they're only aware of other subsystem classes and work with
  each other directly. From the subsystem's perspective a _Facades_ is just
  another client.

### Our Example

![Our example UML diagram][2]

- **PageJsonData** is our _Facade_. It uses our _Subsystem classes_ and
  encapsulates their usage under a single _get_ method which takes a page url and
  returns its data as JSON.  
- **PageDownloader**, **HTMLParser**, **JsonEncoder**, **HtmlTree** are our
  _Subsystem classes_. Each of them execute an individual task or (in case
  of _HtmlTree_) represent an individual structure - as all well designed
  classes should
  do([Single Responsibility Principle](https://blog.cleancoder.com/uncle-bob/2014/05/08/SingleReponsibilityPrinciple.html)).  
- **App** is our _Client_ with a simple _run_ method.

[1]: https://i.ibb.co/840tQkf/Facade.png
[2]: https://i.ibb.co/Y372gPv/Facade-Example.png
