# Advent of code 2020 solutions in PHP
1. Initail actions:
    * Install dependencies:
        + **composer install**

1. Command: **AoC-2020:make**
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

1. Command: **AoC-2020:day**

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

