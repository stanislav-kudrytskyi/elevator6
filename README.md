# Elevator6

"Elevator6" is the implementation of elevator model - a set of entities (components of the business process) and the relationships between them.

The main criterion for adequacy of the model is the waiting time of the elevator user

Application consists of client and server parts.

## Client part
Within the framework of the current implementation, the following set of objects was defined:
- Floors
- Elevator cabin
- Controls to make a call from the cabin (if someone got into cabin)
- Controls to make a call from floor (at any time)
- Management of the application configuration (number of floors, algorithm (strategy) of the elevator movement)

At any discrete point in time, there is a strictly defined application state, for example:
```json
{
    "strategy": "standard",
    "doorsOpened": false,
    "direction": "up",
    "currentFloor": 1,
    "targetFloor": 5,
    "personsInside": 0,
    "numberOfFloors": 5,
    "calls": [{
        "direction": "down",
        "from": 5,
        "to": null
    }, {
        "direction": "down",
        "from": 3,
        "to": null
    }]
}
```
The state mutation is performed only on the client side.
Was added next available actions which will lead to state mutation:
* Make an elevator call from floor (in any time)
* Make an elevator call from cabin (only if person got into cabin)
* Get into cabin (when elevator doors are opened)
* Get out of cabin (when elevator doors are opened)


To receive a conclusion on which floor elevator should go, an api request must be sent to the server.

## Server part
As a request argument is expected to receive an object with a full state. As response to the client will be returned object:
 ```json
 {
     "direction": "down",
     "targetFloor": 3
 }
 ```
 
 There are two algorithms are available at the moment:
  * monkey algorithm (cabin goes randomly goes from floor to floor)
  * "standard" -  more adequate implementation of how the elevator should work