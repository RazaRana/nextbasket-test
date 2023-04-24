# Next Basket Test

My App is a microservices-based application that consists of two microservices: user-service and notification-service. The microservices communicate with each other using RabbitMQ, and they both use a MySQL database for storage. The app is designed using Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS) patterns.

## Requirements
- Docker
- Docker Compose
- NPM

## Installation

### Backend

- Clone the repository: git clone https://github.com/RazaRana/nextbasket-test.git
- Navigate to the project directory: cd nextbasket-test
- Build the Docker images: docker-compose build
- Start the containers: docker-compose up

### Frontend
- Navigate to the project directory: cd nextbasket-test/frontend
- Run npm build
- Run npm start


## Services
### user-service
User service is a Php Symfony based microservice. It uses Symfony messenger for communication. It is using php container and ngnix container to receive requests. Service has two endpoints
- Post /users which receivers user email user first name and user last name and create a user. CreateUserCommand command is dispatched on command.bus bus on receive of this post request and it is routed to amqp transport. and consumed by middleware CreateUserCommandHandler.
- Get /users fetch a list of users stored in the daabase. FindAllUsersQuery query is dispatched on query.bus bus on receive of this get request and it is routed to amqp transport. and consumed by middleware FindAllUsersQueryHandler.
- amqp transport uses exchange exchange1 and queue named user.
- CreateUserCommandHandler dispatch another event UserCreatedEvent after user is added to the database. This event is dispatched on rabbitmq transport.
- rabbitmq transport uses exchange exchange2 and queue named created-users.

### notification-service
Notification service is a Php Symfony based microservice. It runs a consumer worker to listen and consume events on rabbit mq queue named created-users.

- service maps UserCreatedEvent from created-users queue to LogEventToFileHandler. LogEventToFileHandler will log the event to file /var/log/microservice.log in container.

### database

- it uses mysql databse and php doctrine orm

### rabbbit-mq

### Front end in next js
- frontend is written in next js which shows a list of uses and have a button which opens a model to add new uses.
- It uses context api for users list fetch and creation.
- custom hooks are used for business logic


### Test
- test can be run in docker container using comand
  docker exec -it nextbasket-test-user-service-php-1  ./vendor/bin/phpunit src/