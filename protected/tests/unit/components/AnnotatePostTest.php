<?php

class AnnotateTest extends CDbTestCase {

    public $p;

    public function setUp() {
        $this->p = Post::model()->find();
        
    }

    public function testAnnotate() {
        $annotate1 = new AnnotatePost($this->p);
        $annotate1->annotate();
        $this->assertEquals("hey watsup :: DRAFT", $annotate1->getCurrentPost()->title, 'draft title doesnt match bro');
    }

}
