<?php

class scrapIG {


    public function __construct() {
        
    }


    /**
     * Get user complete profile data
     * @param string $url url from instagram containing account name
     * @param boolean $simplaeFormat optional formating result to a simpler array
     * @return array
     */
    function getProfile($url, $simpleFormat=false) 
    {
        $data = $this->getContent($url);

        #$this->echoPre($data);
        //getting profile info
        if( isset($data['entry_data']['ProfilePage'])){
            $data = $data['entry_data']['ProfilePage'][0];
        }else $data = null;

        if($simpleFormat && $data){
            $data = $this->formatProfile($data);
            $data = $this->getLatestPost($data);
        }

        return $data;
    }


    /**
     * Get instagram post detail data 
     * @param string $url url from instagram containing posted feed
     * @param boolean $simplaeFormat optional formating result to a simpler array
     * @return array
     */
    function getPost($url, $simpleFormat=false) 
    {
        $data = $this->getContent($url);

        $this->echoPre($data);
        //getting profile info
        if( isset($data['entry_data']['PostPage'])){
            $data = $data['entry_data']['PostPage'][0];
        }else $data = null;

        if($simpleFormat){
            $data = $this->formatPost($data);
        }

        return $data;
    }


    /**
     * Formating raw data to a simpler profile data
     * @param array $data array rows from profiles content
     * @return array
     */
    function formatProfile($data)
    {
        $profile = [];

        //simplify profile 
        $rawProfile = $data['graphql']['user'];
        $profile = [
            'id'        => $rawProfile['id'],
            'fbid'      => $rawProfile['fbid'],
            'username'  => $rawProfile['username'],
            'full_name' => $rawProfile['full_name'],
            'biography' => $rawProfile['biography'],
            'profile_pic_url'   => $rawProfile['profile_pic_url'],
            'profile_pic_url_hd'   => $rawProfile['profile_pic_url_hd'],
            'category'  => $rawProfile['category_name'],

            'follower'  => $rawProfile['edge_followed_by']['count'],
            'following' => $rawProfile['edge_follow']['count'],
            'posts'     => $rawProfile['edge_owner_to_timeline_media']['count'],
            'channel_posts'=> $rawProfile['edge_felix_video_timeline']['count'],

            'business_address_json' => $rawProfile['business_address_json'],
            'business_phone_number' => $rawProfile['business_phone_number'],
            'business_category_name' => $rawProfile['business_category_name'],

            'is_private' => $rawProfile['is_private'],
            'is_verified' => $rawProfile['is_verified'],
        ];

        //adding formated data to result
        $data['formated']['profile'] = $profile;

        return $data;
    }


    /**
     * Formating raw data to a simpler post detail data
     * @param array $data array rows from profiles content
     * @return array
     */
    function formatPost($data)
    {
        $post = [];

        //simplify post 
        $rawPost = $data['graphql']['shortcode_media'];
        $post = [
            'id' => $rawPost['id'],
            'type' => $rawPost['__typename'],
            'product_type' => $rawPost['product_type'],
            'shortcode' => $rawPost['shortcode'],
            'display_url' => $rawPost['display_url'],
            'display_resources' => $rawPost['display_resources'],
            'caption' => $rawPost['edge_media_to_caption']['edges'][0]['node']['text'],
            'dimensions' => $rawPost['dimensions'],

            'is_video' => $rawPost['is_video'],
            'video_url' => ($rawPost['is_video']==1) ? $rawPost['video_url'] : '',
            'video_duration' => ($rawPost['is_video']==1) ? $rawPost['video_duration'] : 0,
            'video_view_count' => ($rawPost['is_video']==1) ? $rawPost['video_view_count'] : 0,
            'video_play_count' => ($rawPost['is_video']==1) ? $rawPost['video_play_count'] : 0,
            'comment_count' => $rawPost['edge_media_preview_comment']['count'],
            'like_count' => $rawPost['edge_media_preview_like']['count'],

            'time' => $rawPost['taken_at_timestamp'],
            'time_formated' => date("Y-m-d H:i:s", $rawPost['taken_at_timestamp'])

        ];

        //adding formated data to result
        $data['formated']['post'] = $post;

        return $data;
    }


    /**
     * Get 12 latest post from a profile
     * @param array $data array rows from profiles content
     * @return array
     */
    function getLatestPost($data)
    {
        $latestPost = [];

        $rawLatesPost = $data['graphql']['user']['edge_owner_to_timeline_media']['edges'];
        foreach($rawLatesPost as $post){
            $post = $post['node'];
            $latestPost[] = [
                'id' => $post['id'],
                'type'  => $post['__typename'],
                'shortcode' => $post['shortcode'],
                'thumb' => $post['thumbnail_src'],
                'dimensions' => $post['dimensions'],

                'is_video' => $post['is_video'],
                'video_url' => ($post['is_video']==1) ? $post['video_url'] : '',
                'video_view_count' => ($post['is_video']==1) ? $post['video_view_count'] : 0,
                'comment_count' => $post['edge_media_to_comment']['count'],
                'like_count' => $post['edge_liked_by']['count'],
                'caption' => $post['edge_media_to_caption']['edges'][0]['node']['text'],
                'time' => $post['taken_at_timestamp'],
                'time_formated' => date("Y-m-d H:i:s", $post['taken_at_timestamp'])
            ];
        }

        //adding formated data to result
        $data['formated']['latestPost'] = $latestPost;

        return $data;
    }


    /**
     * Get latest comment from a post
     * @param array $data array row from post content
     * @return array
     */
    function getLatestComment($data)
    {
        $latestComment = [];

        $rawLatesComment = $data['graphql']['user']['edge_owner_to_timeline_media']['edges'];
        foreach($rawLatesComment as $cmt){
            $cmt = $cmt['node'];
            $latestComment[] = [
                'id' => $cmt['id'],
                'time' => $cmt['taken_at_timestamp'],
                'time_formated' => date("Y-m-d H:i:s", $cmt['taken_at_timestamp'])
            ];
        }

        //adding formated data to result
        $data['formated']['latestComment'] = $latestComment;

        return $data;
    }


    /**
     * Getting instagram content source and sanitize the data layer info
     * @param string $url url from instagram containing account or post url
     * @return array
     */
    private function getContent($url)
    {
        $rawdata = null;

        //requestion content
        if($content = $this->http_request($url)) {
            
            //scrapping data layer info
            $regx = '/(?<=<script type="text\/javascript">window._sharedData = )(.*?)(?=;<\/script>)/';
            preg_match_all($regx, $content, $output_array, 0);
            
            if( count((is_countable($output_array)?$output_array : [])) ) {
                
                if(count($output_array[0]) > 0){ 
                    
                    //decoding data layer
                    $rawdata = isset($output_array[0][0]) ? json_decode($output_array[0][0], TRUE) : [];
                }
            }
        }

        return $rawdata;
    }


    /**
     * Requesting content by simulating browser access using curl
     * @param string $url url from instagram containing account or post url
     * @return string
     */
    private function http_request($url) {
        // prepare curl
        $ch = curl_init(); 

        // assign url 
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // setup user agent    
        curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());

        // return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl 
        curl_close($ch);      

        // return result
        return $output;
    }

    /**
     * Randomize user agent of browser
     * @return string
     */
    private function getRandomUserAgent() {
        $userAgents = array(
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36", 
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36", 
            "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36", 
            "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36", 
            "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36", 
        );
        $random = rand(0,count($userAgents)-1);
        
        return $userAgents[$random];
    }

    /**
     * debugging utility
     * @param array $data any kind of array
     */
    function echoPre($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
?>