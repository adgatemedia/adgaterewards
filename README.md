# Adgate Reward VC Wall Documentation

## Creating a new VC Wall
### Step 1: Go to [https://panel.adgatemedia.com/](https://panel.adgatemedia.com/)
### Step 2: Click Monetization Tools
![Alt text](/Click_Money_Tools.png?raw=true "Click 'Monetization Tools'")
### Step 3: Click AdGate Rewards
![Alt text](/Click_Adgate_Reward.png?raw=true "Click 'AdGate Rewards'")
### Step 4: Click Create AdGate Rewards Wall
![Alt text](/Create_Adgate_Rewards_Wall.png?raw=true "Click 'Create AdGate Rewards Wall'")
### Step 5: Fill out the following form, each field is described below.
![Alt text](/New_VC_Wall.png?raw=true "New VC Wall")
#### Name:
This	will	be	used	to	identify	your	wall	on	our	panel	and	reporting.
#### Allowed Offer Categories
This	determines	what	types	of	offers	will	show	up	on	your offer	wall.	We	recommend	leaving	this	to	the default	settings.
#### Points (plural)
The	plural	form	of	your	currency.	*Ex: Coins*
#### Points (singular)
The	singular	form	of	your	currency.	*Ex:	Coin*
#### Points (abbreviation)
The	abbreviated	form	of	your	currency.	If	there	is	no	abbreviated	form,	just	use	the	Plural form.	*Ex:	Cns	or	Coins*
#### Conversation rate
How	many	of	your	currency	is	$1	USD	worth?	*Ex:	100	would	mean you	award	100	Coins	for	every	$1	you	earn.*
#### URL of the wall
Enter	the	web	URL	the	wall	we	be	placed	on,	or	the	URL	of	your	App
#### Postback
The	URL	you	would	like	us	to	notify	when	a	conversion occurs.	Click	“More	Information	on	Postbacks” to	see	a	sample and	all	the	available	macros
#### Rounding
You	can	choose how	you	want	decimals	rounded	when	awarding currency. There is also an option to keep currencies as a decimal, up to two decimal places.

## Placing your wall
### Step 1: Obtain your wall ID
You can find your wall id [here](https://panel.adgatemedia.com/affiliate/vc-walls). It will look like the following image:
![Alt text](/Wall_Code_Example.png?raw=true "Wall code example")
You can see our two codes here are **nQ** and **ng**
### Step 2: Determine the user ID
This is a dynamic value that should be replaced with a unique identifier for each of your users. The	user	id	may	be	any	string up	to 255	characters	long.

### Step 3: Adding the iframe to your site
You will take both of the pieces of information obtained in Step 1 & 2 and create an iframe using the following guideline: `https://wall.adgaterewards.com/**YOUR WALL ID (Step 1)**/** USER ID (Step 2)**`. For example:
```html
<iframe src="https://wall.adgaterewards.com/nQ/6d0007e52f7afb7d5a0650b0ffb8a4d1"></iframe>
```

It is also recommended to set the iframe height to that of the users browser. This can be done in either [CSS](http://www.tagindex.net/css/frame/width_height.html) or [inline of the iframe.](http://www.w3schools.com/tags/att_iframe_height.asp)

### Step 4: Postback Information
You'll need to set up a URL endpoint on your server, a postback, that we will call when a user completes an offer, or we receive a chargeback for a previously completed offer.

For more detailed information you can go to [your vc wall](https://panel.adgatemedia.com/affiliate/vc-walls) click "Create AdGate Reward Wall" and then click "More Information on Postbacks" located under the Postback field.

For an example of a plain PHP script handling Postbacks with a PDO database connection see [Plain PHP Postback PDO Example](postback_pdo_example.php).

For an example of a plain PHP script handling Postbacks with an Object see [Plain PHP Postback OO Example](postback_oo_example.php).
