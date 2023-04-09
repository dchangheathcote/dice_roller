# Dice Rolling API

Written as a Wordpress plugin

Dice rolling API for board games

New with rerolls!

https://wp.darrylch.com/wp-json/dch-json/v1/dice_roller?reroll=1&prev=6,2,5,6,1,2,1,6,4,4,5,1

```
{
    "rolls":[
        {
            "roll":[2,6,5,5,6,6,4,3,6,4,2,5,5,3],
            "previous_roll":[1,1,5,5,6,1,4,3,6,4,2,5,5,1],
            "roll_meta":{
                "rerolls":4,
                "roll_groups":{"2":2,"6":4,"5":4,"4":2,"3":2},
                "min_value":4,
                "min":{"gt":10,"lt":4}
                }
        }
    ],
    "request":{
        "reroll":"true"
        "amount_of_dice":14,
        "sides":6,
        "number_of_rolls":1
    }
}
```
