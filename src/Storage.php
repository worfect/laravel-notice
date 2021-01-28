<?php


namespace Worfect\Notice;


interface Storage
{
    public function add( /** array|\ArrayAccess  8.0.0*/ $data);

    public function get();
}
