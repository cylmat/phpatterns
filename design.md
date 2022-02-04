# Design Patterns

Creational
---
    Runtime
Abstract factory: Provide an interface for creating familites of relate objects without specify their concrets classes
Builder: Separate the construction of a complex object from its representation, the construction process create various representations. 
Prototype: Specify the kinds of objects to create using a prototypical instance, and create new objects from this 'skeleton'

    Compile time
Factory: Define an interface for creating object, but let subclasses decide which class to instantiate. 
Singleton: Ensure a class has only one instance, and provide a global point of access to it. 

Structural
---
**Interface**  
Adapter/Wrapper: Convert the interface of a class into another interface clients expect.
Bridge: Decouple an abstraction from its implementation allowing the two to vary independently. 
Facade: Provide a unified interface to a set of interfaces in a subsystem, makes the subsystem easier to use. 

    Runtime
Decorator: Attach additional responsibilities to an object dynamically keeping the same interface, alternative to subclassing.
Proxy: Provide a surrogate or placeholder for another object to control access to it. 

Composite: Compose objects into tree structures to represent part-whole hierarchies, treat individual and compositions of objects uniformly. 
Flyweight: Use sharing to support large numbers of similar objects efficiently. 

Behavior
---
    Runtime
Iterator: Provide a way to access the elements of an aggregate object sequentially without exposing its underlying representation. 
State: Allow an object to alter its behavior when its internal state changes. The object will appear to change its class.
Strategy: Encapsulate and make interchangeabl a family of algorithms. Lets the algorithm vary independently from clients
Visitor: Lets a new operation be defined without changing the classes of the elements on which it operates. 

    Compile time
Template: Template method lets subclasses redefine certain steps of an algorithm without changing the algorithm's structure. 

**Collaboration**  
Ch o Rsp: Avoid coupling the sender of a request to its receiver by giving more than one object a chance to handle the request.
Command: Encapsulate a request as an object, allowing queuing, logging or undoing of requests.
Mediator: Define an object that encapsulates how a set of objects interact. Loose coupling by keeping objects from referring to each other. 
Observer/Push-Sub: Define a one-to-many dependency between objects where a state change in one object results in all its dependents notified. 

**State**  
Interpreter: Given a language, define a representation for its grammar using the representation to interpret sentences. 
Memento: Without violating encapsulation, capture and externalize an object's internal state allowing the object to be restored to this state later. 

More
---
- Creational
Dependency Injection: A class accepts the objects it requires from an injector instead of creating the objects directly. 
Lazy initialization: Delaying the creation of expensive process until the first time it is needed. 
Multiton: Ensure a class has only named instances, and provide a global point of access to them. 
Object pool: Avoid expensive acquisition and release of resources by recycling objects that are no longer in use.

- Structural
Front: The pattern relates to the design of Web applications. It provides a centralized entry point for handling requests. 
Marker: Empty interface to associate metadata with a class. 
Module: Group several related elements, such as classes, singletons, methods, globally used, into a single conceptual entity. 
Twin: Twin allows modeling of multiple inheritance in programming languages that do not support this feature. 

- Behavior
Blackboard: AI pattern. Combining disparate sources of data
Null: Avoid null references by providing a default object.
Servant/Helper: Define common functionality for a group of classes. 
Specification: Recombinable business logic in a Boolean fashion. 

- others
IoC: Custom-written portions of a computer program receive the flow of control from a generic framework
MVC: Used for developing user interfaces which divides the related program logic into three interconnected elements.

    object persistence
Active record: Architectural pattern found in software that stores in-memory object data in relational databases
Data mapper: Data Access Layer that performs bidirectional transfer of data between a persistent data store and an in-memory data representation. 
(Data access layer): Layer of a computer program which provides simplified access to data stored in persistent storage   

Concurency
---
**@ref**: https://en.wikipedia.org/wiki/Concurrency_pattern  

    Reactor_pattern : Event handling pattern for handling service requests delivered concurrently to a service handler by one or more inputs.
    Il est destiné à permettre le traitement événementiel dans un environnement concurrentiel, où les événements peuvent provenir de sources diverses.

Other
---
    Pool: administrer une collection d'objets qui peuvent être recyclés.
    Modèle de Seeheim
    Mémoïsation
    Post-redirect-get
    Support d'initialisation à la demande
    Signaux et slots
    Désignation chaînée
    Double-checked locking
    MapReduce
    Fonction de rappel

---
@see: https://github.com/DesignPatternsPHP/DesignPatternsPHP

---
@refs
- https://www.tutorialspoint.com/design_pattern/index.htm (for diagrams)
- https://en.wikipedia.org/wiki/Software_design_pattern
- https://martinfowler.com/eaaCatalog/index.html
- https://refactoring.guru/design-patterns/php
- https://designpatternsphp.readthedocs.io/en/latest/README.html
- https://springframework.guru/gang-of-four-design-patterns/

UML
---
**@ref**: https://www.uml-diagrams.org/class-reference.html
