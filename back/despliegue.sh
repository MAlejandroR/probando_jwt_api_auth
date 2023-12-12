sudo rm ./public -r
hugo -d public
rsync -avz -e "ssh" ./public/ profesor@proyectosdwa.es:httpdocs/manuel/api


