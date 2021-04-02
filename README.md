**Symfony Api Rest template with dynamic Database connection**

-   Symfony 5
-   PHP7.4
-   api-platform/core
-   webonyx/graphql-php

How it's works?

-   The api receive a request like: `/api/<entities>` or `/api/graphql`
-   This request requires `project-tag` , `project-name` as headers
-   The value of tag is passed as the entity manager pre-configured in the doctrine.yaml file
-   The value of name is passed as the database name we want to be connected.
