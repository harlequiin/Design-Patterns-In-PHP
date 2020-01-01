## Domain Model

_Domain Model_ establishes a web of interconnected objects, where each object
represents some meaningful individual - whether as large as an entire
corporation or as small as a single order.  
_Domain Model_ classes incorporate both the behavior and data.

### How It Works

_Domain Model_ introduces a whole layer of objects that model the business area
you're working with. In _Domain Model_ you'll find objects that mimic the business data
and objects that capture the business rules. Data and processes (behavior) are 
combined to cluster the processes close to the data they're working with.  
Object-oriented domain model will often look similar to the database model,
however it also has significant differences - _Domain Model_ mingles data and
processes together, has multivalued attributes, has complex graph
relationships, uses inheritance, patterns etc.  

### General Structure

As a result of these afromentioned variations - we generally see 2 different styles
of _Domain Model_ in the field:
- a simple _Domain Model_ that closely mimics the database design - with mostly
  one domain object for each database table. A simple _Domain Model_ can be
  implemented using _Active Record_.
- a rich _Domain Model_ can look quite different from the database design - with
  inheritance, GoF patterns, and a complex web of small interconnected
  objects. Rich _Domain Model_ will require a _Data Mapper_ (most likely some sort of 
  [ORM](https://en.wikipedia.org/wiki/Object-relational_mapping)
  [tool](https://en.wikipedia.org/wiki/List_of_object-relational_mapping_software)).

_Domain Model_ should stay as independent and minimally coupled to other layers as
possible. That's because _Domain Model_ is usually a subject to a lot of change
which requires ease of testing and modification. If your _Domain Model_ must
depend on some upper layer - define an interface inside _Domain Model_ (or
_Service Layer_) that the upper layer(s) must implement (something Fowler
calls a _Seperated Interface_ pattern).

### When To Use It

If you have complicated and everchanging business rules with validation,
derivations and calculations - some sort of _Domain Model_ object model is your
best bet. If you have some simple checks and calculations - _Transaction
Script_ might be more appropriate.  
Another major factor in you domain logic choice is familiarity with the
pattern. Acquiring _Domain Model_ design skills take practice and exercise - 
but once you've learned it and experienced the _paradigm shift_ towards
_object-oriented thinking_ - its hard to go back to anything else, including
_Transaction Scripts_.  
Once you've chosen _Domain Model_ - your first choice for database interaction
should be _Data Mapper_. This will keep you _Domain Model_ independent from
your database. When you use _Domain Model_ you may want to consider _Service
Layer_ to give your _Domain Model_ a more distinct and fleshed out API.

### Our Example

![Our example UML diagram][1]

I've borrowed our _Domain Model_ example from Kristopher Wilson's
[The Clean Architecture in PHP](https://leanpub.com/cleanphp) book which
I highly recommend. I've chosen to omit getters and setters in the UML - their
presence can be implied by the attributes. _Domain Model_ is defined by its
relationships and constraints.
- **AbstractEntity** - all of our _Entities_ inherit from this abstract class.
  It holds the _id_ data - meaning that all our _Entities_ that inherit form it
  have a unique id. _Abstract Entity_ can be thought of as a _Layer Supertype_.  
- **Invoice** class holds a reference to an single **Order** class. An **Order**
  class, however, can have multiple **Invoices** refer to it - the multiplicity
  on our association ends show this.  
- **Order** class has a relation to the **Customer** class - it can have
  only one **Customer**, however - a single **Customer** can have multiple
  _Orders_.
If we wanted to change our business rules so that multiple customers
can participate in the same order - we would simply change the multiplicity on
the relationship between _Customer_ and _Order_ class - and perhaps
introduce a association class between them - to illustrate a _many-to-many_
relationship, or simple have _Customer_ array field in the _Order_ class -
there are a lots of ways to translate the UML into code, some more useful
than others - only with experience you can learn to determine which implementation
might be more useful.

This is a fairly simple example and you probably wouldn't benefit much from using
_Domain Model_ here - this is a little bit of conundrum - _Domain Model_ shines
in complex business models, however we don't want try to deconstruct overly
complex examples when we're learning - hence such a simple model. In production
code this _could_ be deemed an [_anemic_](https://martinfowler.com/bliki/AnemicDomainModel.html)
_Domain Model_ which is an _anti-pattern_. We could fix this by adding some
simple validations in our setters - in PHP even a simple type hint is better than
nothing. Quite often developers put all the business logic in _Service Layer_,
however it is recommended to keep the _Service Layer_ thin - it should only
coordinate and delegate the work to the collaborations of domain object in the
_Domain Model_ layer.

[1]: https://i.ibb.co/W2d9k9R/Domain-Model.png
