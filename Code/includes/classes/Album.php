<?php
class Album{
    private $con;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
        $album = mysqli_fetch_array($query);


        $this->title = $album['title'];
        $this->artistId = $album['artist'];
        $this->genre = $album['genre'];
        $this->artworkPath = $album['artworkPath'];
    }
    public function getTitle(){
        return $this->title;
    }
    public function getArtworkPath(){
        return $this->artworkPath;
    }
    public function getGenre(){
        return $this->genre;
    }
    public function getArtist(){
        return new Artist($this->con,$this->artistId);
    }
    public function getNoOfSongs(){
        $query = mysqli_query($this->con,"SELECT id FROM songs WHERE album='$this->id'");
        return mysqli_num_rows($query);
    }
    public function getAlbumId(){
        return $this->id;
    }
    public function getSongIds(){
        //$query = mysqli_query($this->con,"SELECT id FROM songs WHERE album='$this->id' ORDER BY albumOrder ASC ");
        $query = mysqli_query($this->con,"SELECT id FROM songs WHERE album='$this->id' ORDER BY plays DESC");
        $array =  array();
        while ($row = mysqli_fetch_array($query)){
            array_push($array,$row['id']);
        }
        return $array;
    }

    public static function getDropdownAlbum($con){
        $dropDown = ' <select id="insertSongAlbum" class="insertSongAlbum" name="insertSongAlbum">
                        ';

        $query = mysqli_query($con,"SELECT * FROM albums");
        while ($row = mysqli_fetch_array($query)){
            $id = $row['id'];
            $name = $row['title'];
            $dropDown = $dropDown."<option value='$id'>$name</option>";
        }
        return $dropDown."</select>";
    }
}
