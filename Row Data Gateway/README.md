## Row Data Gateway

An object that serves as a _Gateway_ to a single record in a data source.  
One instance handles one row in the database.

Mixing and embedding database access code (like SQL) within application logic
can cause problems - one of which is increased code complexity.
One is forced to visually jump through the code if he/she wants to change the SQL
or the app logic itself. Testing gets awkward too - since you can't test you
application logic and database access in isolation - testing app logic would
also mean database access in you test which can significantly slow down your tests.
A _Row Data Gateway_ give you objects that mirror the individual records in you
record structure (like a relational table) - but can be accessed with the usual
mechanisms of your programming language - in case of PHP the best choice is to
go OOP and represent and individual record as an object.
All database access details are nicely hidden behind an interface.

### How It Works

A _Row Data Gateway_ acts an an object that mimics a single record - in case of
relational databases - a single row. Each column of a database row becomes
an object field.  
It's often hard to tell a difference between _Row Data Gateway_ and _Active
Record_ patterns - the difference is that an _Active Record_ includes both the
data access logic and domain logic while _Row Data Gateway_ just like all
_Gateway_ patterns, is a pure data source architectural pattern.  
Developers have to be aware of few things, for instance - in having multiple _Row
Data Gateways_ that operate on the same table you may find that an update from
one of the gateways overrides an earlier upate by another gateway. Sometimes
it's natural and expected, but sometimes it's not - there's no general way to
prevent this - you as a developer have to be responsible how the logic flows in
you application.

### General Structure

As mentioned - the most common way to implement _Row Data Gateways_ is via an
object where every row column (in case of a relational table) becomes and
object field with accessor methods.  
With _Row Data Gateway_ you're face with a question of where to put the _find_
methods that return the _Row Data Gateway_ objects themselves. You can use
static _find_ methods on the _Row Data Gateway_ itselfs - it's a fairly common
tactic in some libraries (same with _Active Record_), however they rule out
polymorphism in case you want to swap in a different _find_ method for
different data sources or tables. And just like with any static method -
testing it in isolation gets harder if not impossible. Because of these reasons -
it often makes sense to have break out a seperate finder class for each table -
so that each table in a relational database will have on finder class and one
gateway class for the results.

### When To Use It

Similarly to _Table Data Gateway_ - the first choice is whether to use _Gateway_
approach and then - which one.  
_Row Data Gateway_ works great with _Transaction Script_ - it abstracs away
database access code and allows it to be reused easily. It shouldn't use _Row
Data Gateway_ with _Domain Model_ - if domain logic is simple you can just use
_Active Record_ - it does the same job without introducing a separate domain
logic layer. If the domain logic is complex - you're better off using _Data Mapper_
as it decouples the database structure from the domain logic/layer. _Row Data
Gateway_ **could** shield the _Domain Model_ from the database structure if
you're changing the database structure - however you'd now have 3 different
reprepresentations of the same data - one in _Domain Model_, one in _Row Data
Gateway_ and one in the database. Ideally _Row Data Gateway_ should mirror
the database. Having this 3 different reprepresentations of the same underlying
data is one too many.  
Just like _Table Data Gateway_ - _Row Data Gateway_ can work nicely with _Data
Mapper_ - if the _Row Data Gateways_ are automatically generated from metadata.  
When you're using _Row Data Gateway_ with _Transaction Scripts_ - you may
notice that some of your business logic gets duplicated across your scripts -
logic that can be moved inside your _Row Data Gateway_. Moving business logic
in to your _Row Data Gateways_ will graduall turn them into _Active Record_
classes which is often good and presents as a natural evolution of your application. 

### Our Example

![Our example UML diagram][1]

**TableGateway** is our abstract superclass. It defines default _find_ and _delete_ 

[1]: 
