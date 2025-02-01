# Project Documentation

## Setup Instructions

### Environment Variables

All environment variables are stored in a `env.php` (must be .env file) file for security and ease of configuration. These include:

- **Database Configurations**: Host, username, password, and database name.
- **OAuth Credentials**: Google OAuth keys for authentication.
- **SendGrid API Key**: Used for email notifications.
- **Redis Configuration**: Used for caching and performance optimization.

### Database Setup

Ensure the database is properly configured by updating the `env.php` file with your credentials. The project uses **MySQL** with `mysqli_connect` for database interactions.

### OAuth Setup (Google Integration)

OAuth authentication for Google is implemented using `cURL`. This is done to securely handle user authentication. To set up OAuth:

1. Create credentials in the [Google Developer Console](https://console.cloud.google.com/).
2. Enable OAuth and get the Client ID & Client Secret.
3. Add these credentials to the `env.php` ( must create .env file) file.
4. Implemented using `cURL` requests to authenticate users securely.

### Caching & Performance Optimization

For caching and performance, **Redis** is integrated into the project. The Redis extension is added to PHP, and the application revalidates cache on **add/update Employee** actions.

## Architecture Overview

### Directory Structure

```
/project-root
│── .git/            # Git repository metadata
│── pages/           # Application pages
│── src/             # Main source code
│── dump.rdb         # Redis dump file
│── index.php        # Application entry point
│── LICENSE          # License information
│── README.md        # Documentation
```

### Handling Logging

- Logs can be configured to store detailed error and debug information.

### Integration Details

- **Google OAuth**: Used for user authentication.
- **SendGrid**: Used for sending emails.
- **Redis**: Used for caching data and reducing database queries.

## Key Decisions

### Why These Libraries & Frameworks?

1. **SendGrid**: Chosen for reliable email delivery and API-based email management.
2. **Redis**: Integrated to improve caching performance and reduce database load.
3. **Google OAuth**: Implemented with `cURL` for flexibility and security.

 **Technology Selection & Design**
  1.Php
  2. Html
  3. Bootstrap
  4. Css
  5.Jquery
  6.Ajax 
  
**Cloud Aws**
1.Ec2
2.Rds
3.Security Groups
  
Replace with your own credentials to start working
This documentation provides an overview of the system setup, architecture, and key decisions behind the implementation.
