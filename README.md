# Sniff To Wol

Designed for Raspian could be applied to any other setup. These scripts allow you to make your Pi into a clever WOL server. It achieves the goal of being able to Wake Up your target device without taking any manual actions.

For example if you had a Plex Media Service on a powerful PC in your home, the idea is that by just opening the Plex app on your mobile while away from home, you can have you Pi device send a Wake-On-LAN packet to wake up your powerful PC. I have also tried this with TeamViewer with success.

And the reason why these applications work, is because you can also have a dummy Plex service and dummy (or real) TeamViewer Server on your Pi logged in to the same account. When an incoming connection to these services comes in to your Pi, this script will detect this and know that you may also be wanting your PC on at this point so will shoot off the Wake-On-Lan packet.

## Requirements
* wakeonlan `sudo apt-get install wakeonlan`
* PHP (pre-installed)
* You need to know the MAC address of the ethernet port of your powerful PC
* Your powerful PC needs to accept Wake-On-Lan packets (https://www.howtogeek.com/70374/how-to-geek-explains-what-is-wake-on-lan-and-how-do-i-enable-it/)

## Install
```
git clone https://github.com/Ali1/SniffToWol/
```

## Set up
You need to create a service for each port you want to listen to. See below for how to set up a Plex service as an example.

### Plex set up
First install Plex on the raspberry pi to act as a dummy server.
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
This dummy server ensures that the Pi is kept in the loop when you are remotely trying to access Plex media.
Now that you have a Plex server on your raspberry pi, connections to Plex will be made every time a Plex client opens on e.g. on your TV or your phone app.

Now set up SniffToWol for Plex service
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
## FAQ
### My ethernet connection is slow. Can I use wifi and ethernet
On windows you can enable both and WOL should work. Make sure to prioritise your wifi connection to take advantage of the speed. https://www.windowscentral.com/how-change-priority-order-network-adapters-windows-10
