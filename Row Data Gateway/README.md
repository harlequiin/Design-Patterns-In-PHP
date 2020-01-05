## Row Data Gateway

An object that serves as a _Gateway_ to a single record from a data source.  
One instance handles one row in the database.

Mixing and embedding database access code (like SQL) within application logic
can cause problems - one of which is increased code complexity.
One is forced to visually jump through the code if he/she wants to change the SQL
or the app logic itself. Testing gets awkward too - since you can't test your
application logic and database access in isolation - testing app logic would
also mean accessing the database in you test which can significantly slow down
your tests.  
A _Row Data Gateway_ gives you objects that mirror the individual records in you
record structure (like a relational table) - but can be accessed with the usual
mechanisms of your programming language - in case of PHP the best choice is to
go OOP and represent an individual record as an object.
All database access details are nicely hidden behind an interface.

### How It Works

A _Row Data Gateway_ acts as an object that mimics a single record - in case of
relational databases - a single row. Each column of a database row becomes
an object field.  
It's often hard to tell the difference between _Row Data Gateway_ and _Active
Record_ patterns - the difference is that an _Active Record_ includes both the
data access logic and domain logic while _Row Data Gateway_ just like all
_Gateway_ patterns, is a pure data source architectural pattern and includes
only the data access logic.    
Developers have to be aware of few things, for instance - in having multiple _Row
Data Gateways_ that operate on the same table you may find that an update from
one of the gateways overrides an earlier upate by another gateway. Sometimes
it's natural and expected, but sometimes it's not - there's no general way to
prevent this - you as a developer have to be responsible for how the logic flows in
you application.

### General Structure

As mentioned - the most common way to implement _Row Data Gateways_ is via an
object where every row column becomes an object field with accessor methods.  
With _Row Data Gateway_ you're faced with a question of where to put the _find_
methods that return the _Row Data Gateway_ objects themselves. You can use
static _find_ methods on the _Row Data Gateway_ itself - it's a fairly common
tactic in some libraries (same with _Active Record_), however they rule out
polymorphism in case you want to swap out a different _find_ method for
different data sources/tables. And just like with any static method -
testing it in isolation is harder if not impossible. Because of these reasons
it often makes sense to break out a seperate finder class for each table -
so that each table in a relational database will have one finder class and one
gateway class for the results.

### When To Use It

Similarly to _Table Data Gateway_ - the first choice is whether to use a _Gateway_
approach at all and then - which one.  
_Row Data Gateway_ works great with _Transaction Script_ - it abstracs away
database access code and allows it to be reused easily. You shouldn't use _Row
Data Gateway_ with _Domain Model_ - if domain logic is simple you can just use
_Active Record_ - it does the same job without introducing a separate domain
logic layer. If the domain logic is complex - you're better off using a _Domain
Model_ + _Data Mapper_ as it decouples the database structure from the domain 
logic/layer. _Row Data Gateway_ _could_ shield the _Domain Model_ from the database
structure when you're changing the database structure - however you'd now have 3
different reprepresentations of the same data - one in _Domain Model_, one in
_Row Data Gateway_ and one in the database. Ideally the _Row Data Gateway_ should
mirror the database. Having this three different reprepresentations of the same
underlying data is one too many.  
Just like _Table Data Gateway_ - _Row Data Gateway_ can work nicely with _Data
Mapper_ if the _Row Data Gateways_ are automatically generated from the metadata.  
When you're using _Row Data Gateway_ with _Transaction Scripts_ - you may
notice that some of your business logic gets duplicated across your scripts -
logic that can be moved inside your _Row Data Gateway_. Moving business logic
in to your _Row Data Gateway_ will gradually turn them into _Active Record_
classes which is often good and presents a natural evolution of your application. 

### Our Example

![Our example UML diagram][1]

- **UserGateway** is our _Row Data Gateway_ class. It defines and implements
  _insert_, _update_ and _delete_ methods. They don't accept any parameters -
  since the _Row Data Gateway_ corressponds to a single data record - we translate
  every record field to a class attribute - if you want to update and existing
  record - change the attribute through its setter - _update_ method will read it
  and internally construct the appropriate SQL query string. Same with _insert_ -
  simply construct a new _UserGateway_ object, set the appropriate attributes and
  call the _insert_ method.  
- **UserFinder** defines _find_ and _findByUsername_ methods. You can anticipate
  and define custom finder methods depending on your application's needs. As
  mentioned - one of the benefits of a separate finder class is it's testability -
  we can write tests for the _UserFinder_ just like we have tests for the
  _UserGateway_.

[1]: https://i.ibb.co/fCrCs3m/Row-Data-Gateway.png
