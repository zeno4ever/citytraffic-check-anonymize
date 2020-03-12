# citytraffic-check-anonymize
Test how good the 'Citytraffic' methode is to keep your mac private

As far I (Dave Borghuis) can follow the steps of CittyTrafic :

  MAC --> SHA256 --> first(?) 17 characters

For the step MAC -> SHA256 City Traffic use a own methode based on SHA256. I don't know in what way it deviates from the standard. 

See also my (dutch) blog on http://daveborghuis.nl/wp/city-traffic-methode_2020_03_04/

The last step is unclear, what data is removed to go from 64 characters to 17 characters. For this test I asume that only the left 17 characters of the sha265 is used. If you have more details I would like to hear from you or better change the code accordingly. 

According to [Gemeente Enschede](https://www.binnenstadsmonitorenschede.nl/bezoekers-weekcijfers) we have around 50.000 visitors per day 

# Statistics
With the lenght of 17 and 50000 records (or even for 17.000.000 entrys), every record is still unique. In my test program you can define the lenght by option '--shalen='.

Results with length of :

| Length        | dubble | avg records |
| ------------- | ---------:|---------:| 
| 8  |     0|    0|
| 7  |     2|    1|
| 6  |    72|    1|
| 5  |  1172|    1|
| 4  | 15047|    1|
| 3  | 45904|   11|
| 2  | 49744|  194|
| 1  | 49984| 3124|

So in summery, to my opinion (i am no expert) if you reduce the string to 3 or less you get enough big 'groups' to claim you have any form of privacy. Everything above (>3) you don't have enough collision.

## Install
To use this script include Medoo libary. I added this with composer, after clone you could do 'composer update' to install the libary.