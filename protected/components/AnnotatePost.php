<?php

/**
 * 
 */
class AnnotatePost extends CApplicationComponent {

    protected $currentPost;

    function __construct(Post $p) {
        $this->currentPost = $p;
    }

    /**
     * This function will return a text with text in it.
     * @return [type] [description]
     */
    public function annotate() {
        $this->currentPost->title = $this->currentPost->title . " :: DRAFT";
    }

    public function getCurrentPost() {
        return $this->currentPost;
    }

}

?>