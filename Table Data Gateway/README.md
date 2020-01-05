## Table Data Gateway

An object that serves as a _Gateway_ to a database table.  
One instance handles all the rows in the table.

Mixing SQL with application logic can cause problems - one of which is hard to
read code - one is forced to sift through it if he/she wants to change the SQL
or the app logic itself. A _Table Data Gateway_ holds all the SQL for accessing
a single table or view: selects, updates, inserts, deletes. The application
code calls its methods in order to interact with the database.

### How It Works

_Table Data Gateway_ is usually stateless - its role is only to push data back
and forth. The trickiest thing about _Table Data Gateway_ is how it returns
information from the query. Even a simple find-by-ID query can return multiple
data items, but many languages, like PHP, give you only a single return value.
One way is to return some simple data structure - such as a _map_, or and _associative
array_. It works but it also may force the data to be copied out of the record set
that comes from a database into the map (in PHP's PDO access interface you can
configure what type of structure the query returns - specifying FETCH_ASSOC
value in PDO connection options or in a _fetch_ call will return an associative
array). Maps don't have an explicit interface - a better solution is to use
some sort of _Data Transfer Object_. It's another object to create but it can
be used elsewhere. In PHP you can make use of PDO::FETCH_OBJ option for the
connection and data fetching.  
In many environments that use _Record Set_, such a .NET, you can simply use the
set itself since it gets returned from the SQL query - however it can get quite
messy - ideally an in-memory object shouldn't know anything about the SQL
interface. Substituting databases can get difficult since you might need to
create _Record Sets_ manually in order for database access to stay compatible
with your application, and not every persistent storage method uses them.  
If you're using a _Domain Model_ you can have the _Table Data Gateway_ return
the appropriate domain object. The issue with this is that now you have
bidirectional dependencies between the domain objects and the gateway, the two
are now closely connected -  which isn't a terrible thing but it's something to
look out for, since _Domain Model_ is meant to be completely independent (you
could use a _Seperated Interface_ for gateways).

### General Structure

A _Table Data Gateway_ has a simple interface, mostly consisting of find
methods to get data from the database, and update, insert, and delete methods
to modify it. Each method puts the input parameters into a SQL call and executes
the SQL against the database.The Table Data Gateway is usually stateless, as
its role is to push data back and forth.

### When To Use It

Similarly to _Row Data Gateway_ - the first choice is whether to use _Gateway_
approach at all, and then - which one. _Table Data Gateway_ is perhaps the
easiest database interfacing pattern to use since it maps nicely onto database
table and because of that - offers a natural point to encapsulate the precise
access logic of the data source.  
_Table Data Gateway_ works best with a _Table Module_ where it produces a record
set data structure for the _Table Module_ to work with. Just like all _Gateway_
patterns it also works well with _Transaction Scripts_ - the choice between
_Row Data Gateway_ and _Table Data Gateway_ really boils down to how the
scripts deal with multiple rows of data.  
_Data Mappers_ can talk to the database via _Table Data Gateway_ - especially
if we use metadata for gateway and handcode the actual mapping.  
Stored procedures within databases are often organized as _Table Data Gateways_.
For instance - _insert_ and _update_ stored procedures encapsulate the actual table
structure. Same for _find_ procedures. _Table Data Gateways_ therefore can
encapsulate the database access in such a way that using the SQL to operate on
data and using stored procedures can be _hidden_ under the same interface.

### Our Example

![Our example UML diagram][1]

- **TableGateway** is our abstract superclass. It defines default _find_ and _delete_
  methods which both use an _id_ parameter. It also defines abstract _insert_
  and _update_ methods, with _update_ accepting a mandatory id parameter.
- **UserGateway** and **PostGateway** both define their specific find methods -
  _findByUsername_ and _findByUser_ respectively and implement the abstract
  _insert_ and _update_ methods according to their specific needs.
We could define _insert_ and _update_ methods in the superclass (perhaps each of
them accepting an associative array of fields => values) and thus avoid the
duplication, however this is a trivial enough example and changes/extensions
wouldn't be too hard to make. And I've chosen to implement the methods with a
parameter for each relevant database field to make the method signatures more
consistent accross the classes.

[1]: https://i.ibb.co/xDwcd85/Table-Gateway.png
