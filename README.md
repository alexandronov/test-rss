# RSS Word Counter

### Setup

1. Download and install Make and Docker if you don't have them

2. To start Application, execute:

    ```bash
    $ make
    ```

1. To make sure everything is up run

    ```bash
    $ docker-compose ps
    ```

### Usage

By default services will be available on these addresses

    | Service    | Address                |
    |------------| -----------------------|
    | website    | http://localhost:8011  |
    | postgres   | localhost:54320        |

To execute tests from outside of container run
    ```
    $ make test
    ```

To enter php-fpm container (for example to use symfony maker) run
    ```
    $ make ssh
    ```
