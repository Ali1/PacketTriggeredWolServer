# SniffToWol

## Requirements
* wakeonlan `sudo apt-get install wakeonlan`
* PHP (pre-installed)

## Install
```
git clone https://github.com/Ali1/SniffToWol/
```

## Set up
You can set up as many or as few port listeners as you want, each with it's own MAC address.

### Plex set up
First install Plex on the raspberry pi
(Thanks to https://thepi.io/how-to-set-up-a-raspberry-pi-plex-server/)
```
wget -O - https://dev2day.de/pms/dev2day-pms.gpg.key | sudo apt-key add -
echo "deb https://dev2day.de/pms/ jessie main" | sudo tee /etc/apt/sources.list.d/pms.list
sudo apt-get update
sudo apt-get install -t jessie plexmediaserver
sudo nano /etc/default/plexmediaserver.prev
sudo service plexmediaserver restart
hostname -I
sudo nano /boot/cmdline.txt # At the bottom of the command line text file, type ip= followed by your IP address that you got from the command above. Save and exit the file (CTRL+X, then Y, then Enter).
sudo reboot
```
Then go to http://localhost:32400/web/index.html on the pi and log in to your Plex account
It should automatically auto-start on every reboot.
Now that you have a Plex server on your raspberry pi, connections to Plex will be made every time a Plex client opens on e.g. on your TV or your phone app.

Now set up SniffToWol for Plex
```
cd /home/pi
cp SniffToWol/Examples/Plex/plextowol.sh ./
```
Now configure the MAC address of the PC that you want to wake up
```
nano plextowol.sh # change mac address at the end of the command
```
Now install the plextowolserver
```
sudo cp Examples/Plex/plextowol.service /lib/systemd/system/
sudo systemctl enable plextowol
sudo systemctl start plextowol
```
