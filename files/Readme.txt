vocHackingShop — Brute Force Practice Lab
==========================================
Created by: VaultofCodes.in | For educational use only

WHAT THIS IS
------------
A deliberately vulnerable login page for practising brute
force attacks using Hydra. Runs entirely on your own machine.
Nothing goes online.

REQUIREMENTS
------------
- Kali Linux (VM or native)
- That's it — Apache and PHP are already installed on Kali

STEP 1 — Copy the login page
-----------------------------
Extract the zip file provided then copy the login page into the web root location

sudo cp  /[location]/vocHackingShop/login.php /var/www/html/login.php

for example= sudo cp  /home/kali/vocHackingShop/login.php /var/www/html/login.php

(make sure to use the correct path of your file)

STEP 2 — Start Apache
----------------------
sudo systemctl start apache2

STEP 3 — Open in browser
-------------------------
Open Firefox and go to: http://localhost/login.php
You should see the vocHackingShop login form.

STEP 4 — Prepare the wordlist
------------------------------

STEP 5 — Attack with Hydra
-----------------------------------------

STEP 7 — Login with found credentials
---------------------------------------
Once Hydra finds a password, go to http://localhost/login.php
and log in with those credentials to confirm.

STEP 8 — Clean up when done
-----------------------------
sudo systemctl stop apache2
sudo rm /var/www/html/login.php

COMMON ISSUES
-------------
Page not loading       → Make sure Apache is started (Step 2)
Hydra not installed    → sudo apt install hydra -y
rockyou.txt not found  → sudo apt install wordlists -y
Port 80 in use         → sudo systemctl stop apache2, then start again

IMPORTANT
---------
Only attack http://localhost — your own machine only.
Never use these techniques on systems you do not own.
This lab is for classroom learning only.
