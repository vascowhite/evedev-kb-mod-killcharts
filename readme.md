# KillCharts by vasco di #

---
## This project is no longer supported. Feel free to copy the code and use as you wish.

Developed for version 3.0+ of EVE Development Network Killboard, created for EVE Online corporations and alliances. Based on the EVE-Killboard created by rig0r, it is now developed and maintained by the EVE-Dev group. All EVE graphics and data used are property of CCP.

V2.0 Completely rewritten and revised June 2011
The code has been completely rewritten since version 1 to use built in EDK routines as much as possible. It should now comply with all your board settings and some of the annoying little bugs from version 1 should now be cleared.
**I will no longer support versions < 2.0 of this mod.**

This mod works with **EDK 3** and above only.

It shows a table based graph on the front page.

![http://www.vascowhite.co.uk/table.jpg](http://www.vascowhite.co.uk/table.jpg)

## Installation ##
Download the zip file and unzip into the mods directory of your kb. It doesn't overwrite any existing files, so there shouldn't be any problems there, thanks to the work of the guys developing EDK3! You rock  :geek: .

Once it has unzipped go to admin/modules on your board and enable the **KillCharts** mod.

There is no warranty with this mod, you install it and use it at your own risk.


## Settings ##
After installing and enabling the mod a link to the settings page should apear as indicated by the red 1 in the image below. You may need to refresh the page to see this.

### Explanation of options ###
  * #### Number of days to trend ####
> The number of days that will be charted. I found 30 worked best for  me, so this is the default. In fact I found that more than 30 looks too crowded, so this is the limit.

  * ### Colour of Kill Bars ###
The colour that kills will be displayed in.

  * #### Colour of Loss Bars ####
The colour that losses will be displayed in.
  * #### Background Colour ####
The colour of the chart background.
  * #### Reset Default Values ####
Does what it says on the tin :


![http://www.vascowhite.co.uk/settings.png](http://www.vascowhite.co.uk/settings.png)


---


**Use the issues page to report bugs/get support**

## Version History ##

  * V1.0 Total re-write and revision.
Released 22nd February 2010

  * V1.01 7th September 2010.
Fixed bug preventing mod from working with EDK3.2 (Thanks to Kovell for the tip)
Will not yet work with multiple corps.

  * V2.0 June 2011.
Completely rewritten (again) to use built in code as much as possible.
Removed flash option to simplify code. This option or a `<canvas>` based option may be reinstated in the future.

  * V2.01 1st July 2011
Added ability to navigate through chart to page showing 1 day's activity.

  * 14th October 2015
 - Migrated from to Google Code to Github.
 - Removed the RGraph feature as this was being used contrary to the EULA for that package. Also, I had stupidly hosted the RGraph files on my own server, so it was getting hammered!