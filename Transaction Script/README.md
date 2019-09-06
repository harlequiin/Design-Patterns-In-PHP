## Transaction Script

Organizes business logic by procedures where each procedure handles a single
request from the presentation.

Most business applications can be imagined as a series of transactions.  
One transaction may simply view/display the information, another can make changes to
it and perform validations and calculations on it. The point is - each
interaction between a client and a server contains a certain amount of logic.  
A _Transaction Script_ organizes all this logic primarily as a single
procedure - making calls to the database directly or through a simple database wrapper
(perhaps a [DBAL](https://en.wikipedia.org/wiki/Database_abstraction_layer)).
Each transaction will have its own _Transaction Script_, however common subtasks
can be broken into subroutines.  
M. Fowler. coined the term **Transaction Script** because most of the time we’ll have one
_Transaction Script_ for each database transaction.


### How It Works

Domain logic is primarily organized by the transactions that you carry out in
the application. I.e. if you need to book a hotel room - the logic to check
the availability, calculate rates, update the database - will be found inside
a _bookHotelRoom()_ procedure or something similar.  
With _Transaction Script_ approach you don't have to worry what other
transactions are doing - your task is to get the input, interrogate the
database, manipulate and save your results to the database. This is how most
PHP scripts worked in the early days - as a server page with global scripts and all 
the logic necessary for that particular transaction mixed together.

Most of the PHP applications before url rewriting took place were an enormous set
of .php files organized in a hierarchy of directories. Each of these files
is a full _Transaction Script_, and an entry point for HTTP requests which are routed
to it by the webserver.

You may notice that _Transaction Scripts_ are in some ways similar to
_Controllers_ in _Model View Controller_ pattern - the difference however is
that controllers are not implemented as standalone scripts - they are
declarative layer over a rich object model. The application logic in them is
request-specific while the lower layer factors out common business logic that
can be reused.


### General Structure

You can organize you _Transaction Scripts_ as purely procedural - with global procedures, or
you can organize you scripts into classes in 2 general ways:
- have several _Transaction Scripts_ packed in a single class where each class
  defines a subject area of related _Transaction Scripts_. This is a straightforward and
  best way for most cases.
- have each _Transaction Script_ in it's own class using the _Command_ pattern.
  Here you define a supertype for your commands that specifies some execute
  method in which _Transaction Script_ logic sits. This allows you to
  manipulate instances of scripts as objects at runtime, however there's rarely
  need for this in systems with simple domain logic.

Try to separate your _Transaction Scripts_ as much a possible - at least put them in
separate subroutines (functions) or ideally - put them in classes in one of two ways
mentioned above, and separate them from the presentation and data source classes. 
Don't have any calls to the presentation from within a _Transaction Script_ 
(it's generally considered a bad practice to have any dependencies going from the
domain logic to the presentation logic).

### When To Use It
Organizing domain logic this way is natural for applications with small logic.
_Transaction Script_ has very little overhead in understanding and performance.

If the domain logic grows more complex it gets harder to maintain and enhance
your code in a well-organized way. A particular problem with _Transaction
Scripts_ is code duplication between transactions - especially common code like database
access, presentation etc. We can carefully refactor it, but more complex
business logic/domains need to prefer a _Domain Model_ pattern for more
elaborate structuring.

### Our Example

![Our example UML diagram][1]

**User** class aggregates our _Transaction Scripts_ which are all - as you guessed it - user
related. What each _Transaction Script_ method does can be easily implied by
its name. _listUsers()_ lists all users, _addUser()_ adds a user etc. Each
_Transaction Script_ routine runs and fulfills a seperate request.  
All of our _Transaction Scripts_ execute SQL queries and/or output the HTML directly.
We could seperate and abstract the presentation and database access further.  
If our domain logic gradually becomes more complex - we'd probably refactor
our example to use _Domain Model_.

[1]: https://i.ibb.co/vzPLnXV/Transaction-Script.png
