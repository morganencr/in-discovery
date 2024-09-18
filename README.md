IN:DISCOVERY. is a website dedicated to discovering emerging bands and artists in the punk, rock, metal, and hardcore scenes. Our goal is to highlight lesser-known talents and provide them with a platform to be heard.

## Features :

- Band and Artist Catalog: Discover bands sorted by musical genre (punk, rock, metal, hardcore).

- Suggestion Submission: Visitors can submit their own band discoveries via a suggestion form. Each submission can include the band's name, a link to listen to their music, and an optional comment.

- Concert Calendar: View upcoming concerts and events related to the featured bands.

- Back Office: Content management through an admin interface accessible via a Konami code, facilitated by frameworks like Bootstrap for an enhanced user experience.

## Technologies used :

- Frontend: HTML, CSS, JavaScript.

- Backend: PHP, database management with MySQL.

- Database Management: phpMyAdmin for simplified management.

- Containerization: Use of Docker for the development environment (PHP, MySQL, phpMyAdmin).

## Prerequisites :

- Before starting, make sure you have the following tools installed on your machine:

→ Docker
→ Docker Compose

## Installation :

1 Clone the project repository:

git clone https://github.com/morganencr/in-discovery.git
cd in-discovery

2 Launch the Docker containers: 

- Use Docker Compose to build and start the necessary containers:

docker-compose up  --build

This will start the containers for PHP, MySQL, and phpMyAdmin.

3 Access the application:

Once the containers are running, you can access the site by opening your browser and navigating to http://localhost:8019.

## Usage : 

- Navigation: Browse the different sections of the site to discover bands and view upcoming events.

- Submit a Discovery: Use the suggestion form to submit bands you’d like to see featured on the site.

- Administration: Log in to the admin interface (back office) to manage content, bands, and events. (Admin access only.)

## Contribution

Contributions are welcome. If you wish to contribute to IN:DISCOVERY., 
please follow these steps :

- Fork the project..

- Create a branch for your feature (git checkout -b my-new-feature).

- Make your changes and commit them (git commit -m 'Add a new feature').

- Push your changes (git push origin my-new-feature).

- Open a Pull Request.

## Acknowledgements : 

Thanks to all contributors and everyone who supports the underground music scene!