#!/bin/sh

sudo tcpdump dst port 32400 -l | php SniffToWol/StreamToWol.php 60:45:cb:82:06:d0
