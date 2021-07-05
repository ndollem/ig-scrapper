<!-- ABOUT THE PROJECT -->
## About The Project

Instagram as part of facebook are quiet strict on getting the users data or post. 
Event though they providing an API for this, it seems a little bit frustating when reading the Do and DONT section on the docs.
As developers usually we try to search a shortcut to get what we wanted, event through a custom or non legal way. 
And this is one of it

What we offers here:
* Getting users profile data as details as possible
* Getting users post data in various type (Image, video, IGTV and Reel). Stories not included.
* Getting list of lates post of the users

All this was scrap from instagram webpage content source, by sanitizing the data layer info available on the content.
We just need to break it down and it's available for us to read.


<!-- GETTING STARTED -->
## Getting Started

Just clone this project and use the library to your project

### Example result

This is an example result 
* Profile data
    ```sh
    [profile] => Array
        (
            [id] => 1176128384
            [fbid] => 17841400011538377
            [username] => thedailyshow
            [full_name] => The Daily Show
            [biography] => Visit dailyshow.com/act to take action against the issues you care about most
            [profile_pic_url] => https://instagram.fcgk10-1.fna.fbcdn.net/v/t51.2885-19/s150x150/118204832_749207075859433_2329116517211050597_n.jpg?tp=1&_nc_ht=instagram.fcgk10-1.fna.fbcdn.net&_nc_ohc=lRCm1PBzWa4AX_yZo-0&edm=ABfd0MgBAAAA&ccb=7-4&oh=c1c108e9e57a8e2d68652def2e94b22d&oe=60E9789A&_nc_sid=7bff83
            [profile_pic_url_hd] => https://instagram.fcgk10-1.fna.fbcdn.net/v/t51.2885-19/s320x320/118204832_749207075859433_2329116517211050597_n.jpg?tp=1&_nc_ht=instagram.fcgk10-1.fna.fbcdn.net&_nc_ohc=lRCm1PBzWa4AX_yZo-0&edm=ABfd0MgBAAAA&ccb=7-4&oh=7c17adeda9b6d9ff6e082b59690d45c5&oe=60E888A2&_nc_sid=7bff83
            [category] => TV Show
            [follower] => 8756705
            [following] => 614
            [posts] => 6171
            [channel_posts] => 1825
            [business_address_json] => {"city_name": null, "city_id": null, "latitude": null, "longitude": null, "street_address": null, "zip_code": null}
            [business_phone_number] => 
            [business_category_name] => Content & Apps
            [is_private] => 
            [is_verified] => 1
        )
    ```

* Image post data
    ```sh
        Array
        (
            [id] => 2608283432919625256
            [type] => GraphImage
            [shortcode] => CQye_aEte4o
            [thumb] => https://instagram.fcgk10-1.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/s640x640/209256469_1445525845815162_4678933002836753875_n.jpg?tp=1&_nc_ht=instagram.fcgk10-1.fna.fbcdn.net&_nc_cat=106&_nc_ohc=s12zWWFUZ3oAX8wI68w&edm=ABfd0MgBAAAA&ccb=7-4&oh=661e51e886ef230faaf1f121c6b51df4&oe=60EA49AA&_nc_sid=7bff83
            [dimensions] => Array
                (
                    [height] => 750
                    [width] => 750
                )

            [is_video] => 
            [video_url] => 
            [video_view_count] => 0
            [comment_count] => 716
            [like_count] => 36658
            [caption] => Being in Congress must be an amazing job if the biggest threat is having to do less work
            [time] => 1625151647
            [time_formated] => 2021-07-01 15:00:47
        )
    ```

* Video post data
    ```sh
        Array
        (
            [id] => 2610548361793949372
            [type] => GraphVideo
            [shortcode] => CQ6h-ddtM68
            [thumb] => https://instagram.fcgk10-1.fna.fbcdn.net/v/t51.2885-15/e15/c236.0.607.607a/210436328_180220397407757_6698157285296056885_n.jpg?tp=1&_nc_ht=instagram.fcgk10-1.fna.fbcdn.net&_nc_cat=1&_nc_ohc=FtquV9vlOo8AX9t6bFp&edm=ABfd0MgBAAAA&ccb=7-4&oh=efcde48a4295436f62b58452ec180e37&oe=60E4F7E4&_nc_sid=7bff83
            [dimensions] => Array
                (
                    [height] => 607
                    [width] => 1080
                )

            [is_video] => 1
            [video_url] => https://instagram.fcgk10-1.fna.fbcdn.net/v/t50.2886-16/210956410_125551086394105_1026679154812453786_n.mp4?_nc_ht=instagram.fcgk10-1.fna.fbcdn.net&_nc_cat=101&_nc_ohc=M3B_0ahapuAAX_F96Rv&edm=ABfd0MgBAAAA&ccb=7-4&oe=60E4F043&oh=fa3523d309ad661ccfc382b8de8a76c9&_nc_sid=7bff83
            [video_view_count] => 231004
            [comment_count] => 524
            [like_count] => 25370
            [caption] => Over 500 rioters have been criminally charged for attacking the U.S. Capitol this year. Can you catch ‘em all?!
            [time] => 1625421672
            [time_formated] => 2021-07-04 18:01:12
        )
    ```
