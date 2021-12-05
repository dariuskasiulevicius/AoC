# Advent of code 2020, 2021 solutions in PHP
1. Initail actions:
    * Install dependencies:
        + **composer install**

2. Command: **AoC-2021:make**
   * Same as on 2020
3. Command: **AoC-2021:day**
   * Same as on 2020
4. Command: **AoC-2020:make**
    * Description:
        + Command that creates boilerplate code for selected day
    * Usage:
        + **AoC-2020:make** [options] [--] \<**day**>
    * Arguments:
        + **day** Day number. Examples: <5>, <27>.
    * Options:
        + **--force** Remove/delete all data on selected day directory before creating from template
    * Examples:
        + ./run AoC-2020:make 5
        + ./run AoC-2020:make --force 5

5. Command: **AoC-2020:day**

    * Description:
        + Command that runs code for selected day
    * Usage:
        + **AoC-2020:day** [options] [--] <**day**>
    * Arguments:
        + **day** Day number. Examples: <5>, <27>.
    * Options:
        + **-d, --data=DATA** Data input file name with/without full path [default: "Data.txt"]
        + **-v**  Increase the verbosity of messages
    * Examples:
        + ./run AoC-2020:day 5
        + ./run AoC-2020:day -v 5 
        + ./run AoC-2020:day -v -d Demo.txt 5 

