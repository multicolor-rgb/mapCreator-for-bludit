<?php
class mapCreator extends Plugin {

        public function init(){
            $this->dbFields = array(
        'widthyt'=> '',
        'heightyt'=> '', 
            );

            $this->customHooks = array(
                'getMapCreator'
            );
}

public function siteHead() {   
echo '<link rel="stylesheet" href="'.$this->domainPath().'css/leaflet.css"/>';
}

public function adminHead() {
echo '<link rel="stylesheet" href="'.$this->domainPath().'css/leaflet.css"/>';
}
 

     

public function adminView(){

  // Token for send forms in Bludit
  global $security;
  $tokenCSRF = $security->getTokenCSRF();

#generator
          

$html = '<link rel="stylesheet" href="'.DOMAIN.'/plugins/mapCreator/css/leaflet.css">';

$html .='<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

<style>.mapcreator .uil{font-size:1.1rem}</style>

<h3>Create Map</h3>
<div style="margin:10px 0;display:block;width:100%;border:solid 1px #ddd;background:#fafafa;margin-bottom:15px;padding:10px;box-sizing:border-box;">

<h3>Get the coordinates of a place</h3>

<ul>
    <li>On your computer, open <a href="https://www.google.com/maps" target="_blank">Google Maps</a>.  </li>
    <li>Right-click the place or area on the map.</li>
    <li>This will open a pop-up window. You can find your latitude and longitude in decimal format at the top.</li>
    <li>To copy the coordinates automatically, left click on the latitude and longitude.</li>
    <li>Paste into input on MapCreator</li>
</ul>

</div>

<form method="POST" class="mapcreator" style="background:#fafafa;border:solid 1px #ddd; box-sizing:border-box;padding:10px;">

<form method="POST" action="#" style="background:#fafafa;border:solid 1px #ddd; box-sizing:border-box;padding:10px;margin-top:20px;">

<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="'.$tokenCSRF.'">

<i class="uil uil-info-circle" style="padding-right:10px;"></i><input type="text" name="namemap" required placeholder="map name" style="padding:5px;width:95%;display:inline;margin-bottom:10px; box-sizing:border-box;">

<i class="uil uil-arrows-shrink-v" style="padding-right:10px;"></i><input type="text" name="height"  required placeholder="map height example (400px or 100vh)" style=" width:95%;display:inline;padding:5px;width:95%; box-sizing:border-box;margin-bottom:10px;">

<i class="uil uil-search-plus" style="padding-right:10px;"></i><input type="text" name="zoom"  required placeholder="map zoom example (0-100)" style="padding:5px;width:95%;display:inline; box-sizing:border-box;margin-bottom:10px;">

<i class="uil uil-map" style="padding-right:10px;"></i><input type="text" name="localization"  required placeholder="map center localization (place coordinates example: 54.22811, 20.99442) can be the same like point" style="padding:5px;width:95%;display:inline; box-sizing:border-box;margin-bottom:10px;">

<p style="margin:0;margin-bottom:10px;"> Mouse scroll wheel zoom?</p>

<i class="uil uil-mouse" style="padding-right:10px;"></i> <select name="mousescroll" style="padding:6px;display:inline-block;width:95%; box-sizing:border-box;margin-bottom:10px;border:solid 1px rgba(0,0,0,0.3);background:#fff;">
    <option value="true">Yes</option>
    <option value="false">No</option>
</select>

<div style="display:flex;align-items:center;justify-content:space-between;background-image:linear-gradient(to right,#ddd,transparent);border-right:none;padding:10px;width:100%;margin-left:0;border-left:5px solid #D61C4E;margin-top:10px;">
    <b>Add point on map</b><br> 
    <button class="addnewpoint" style="background:#D61C4E;color:#fff;border:none;padding:10px;" ><i class="uil uil-plus-square"></i></button>
</div>

<div class="nextpoint"></div>
<div style="width:100%;height:30px"></div>

<i class="uil uil-map-marker" style="padding-right:10px;"></i><input type="text" name="localizationpoint[]"  required placeholder="marker localization point (place coordinates example: 54.22811, 20.99442)" style="margin-top:10px;padding:5px;width:97%; box-sizing:border-box;margin-bottom:10px;display:inline"><br>

<i class="uil uil-chat" style="padding-right:10px;"></i><input type="checkbox" name="showpopup[]" style="margin-top:10px;margin-bottom:10px;"> Show popup?

<textarea name="popupcontent[]" id="popupcontent"></textarea>

<input type="submit" style="background:#000;color:#fff;padding:10px 15px;border:none;margin-top:15px;" value="Create Map" name="createmap">

</form>';

$html .= '
<script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>';


$html .="<script>CKEDITOR.replace(popupcontent, {

    filebrowserWindowWidth: '730',
    filebrowserWindowHeight: '500',
  toolbar:'advanced'
});
</script>";



 
$html .= "<script>
let countPoint = 1;
const addBtn = document.querySelector('.addnewpoint');

addBtn.addEventListener('click',e=>{

e.preventDefault();

document.querySelector('.nextpoint').insertAdjacentHTML('afterbegin',`

<div style='width:100%;height:30px'></div>

<i class='uil uil-map-marker' style='padding-right:10px;'></i><input type='text' name='localizationpoint[]'  required placeholder='marker localization point (place coordinates example: 54.22811, 20.99442)' style='margin-top:10px;padding:5px;width:97%;display:inline; box-sizing:border-box;margin-bottom:10px;'>
<br>

<i class='uil uil-chat' style='padding-right:10px;'></i><input type='checkbox' name='showpopup[]' style='margin-top:10px;margin-bottom:10px;'> Show popup?

<textarea name='popupcontent[]' id='popupcontent`+countPoint+`'></textarea>

`)

CKEDITOR.replace('popupcontent'+countPoint, {

    filebrowserWindowWidth: '730',
    filebrowserWindowHeight: '500',
    toolbar:'advanced',

});

countPoint++;

});

</script>";



echo $html;


echo '<h3 class="mt-3">Maps list</h3>';



#listmap

$path = PATH_PLUGINS.'mapCreator/mapCreated/*.txt';

$filenames = glob($path);




foreach ($filenames as $filename) {
    
    echo '<form method="POST" action="#" style="background:#fafafa;border:solid 1px #ddd; box-sizing:border-box;padding:10px;margin-top:20px;">';

echo '<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="'.$tokenCSRF.'">';

    $base = basename($filename);

    $nename = substr($base, 0, -4);

    echo  '<h3 style="margin-top:10px;">'.$nename . '</h3>   ';

    echo '<code class="copycode" style="background:#fafafa;border:solid 1px #ddd;width:100%;display:block;margin-bottom:10px;box-sizing:border-box;padding:10px;">
    &#60;?php getMapCreator("'.$nename.'");?&#62;
     </code>';

    echo '<input type="text" name="dir" value="'.$filename.'" style="display:none">
    <textarea name="editcontent" class="editcontent" style="width:100%;height:250px;background:#003865;color:#fff;box-sizing:border-box;padding:5px;">';
    
    echo file_get_contents($filename);

    echo '</textarea>';

    echo '<div class="border p-2 copyme"><button class="btn btn-dark">Copy and paste on source TinyMce or Markdown</button></div>';

    echo '<div style="height:250px;width:100%;overflow:hidden;margin-top:10px;">'.file_get_contents($filename).'</div>';

    echo '
    <input type="submit" name="SaveEdit" value="Save Edited" style="margin-top:10px;margin-right:10px;background:#003865;padding:10px 15px;color:#fff;border:none;">
 
    <input type="submit" name="deletemap" onclick="return confirm(`Are you sure you want to delete?`)"  value="Delete Map" style="cursor:pointer; background:#D61C4E;padding:10px 15px;color:#fff;border:none;pointer:cursor;margin-bottom:5px;">
 ';
 
 echo '</form>';

 






 if(isset($_POST['SaveEdit'])){

    file_put_contents($_POST['dir'],$_POST['editcontent']);
     echo("<meta http-equiv='refresh' content='0'>");
 };

 if(isset($_POST['deletemap'])){
     unlink($_POST['dir']);
     echo("<meta http-equiv='refresh' content='0'>");
 };

}



echo '<form action="https://www.paypal.com/cgi-bin/webscr" class="moneyshot" method="post" target="_top" style="display:flex; flex-direction:column; margin-top:10px;padding:20px;box-sizing:border-box;width:100%;align-items:center;justify-content:space-between;background:#D61C4E;color:#fff;">
    <p style="margin:0;padding:0;">If you want support my work  via paypal :) Thanks!</p>
    <input type="hidden" name="cmd" value="_s-xclick" />
    <input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL" />
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
    <img alt="" border="0" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" />
    
    <div style="width:100%;height:15px;"></div>
    Plugin based on <a href="https://leafletjs.com/" style="color:#fff" >leaflet.js</a>
    </form>';


 

echo '
<script>

document.querySelectorAll(".copyme").forEach((x,i)=>{

    x.addEventListener("click",(e)=>{

        e.preventDefault();
 

        navigator.clipboard.writeText(document.querySelectorAll(".editcontent")[i].value);
        alert ("Copied! Now paste on source code on TinyMce or Markdown everytime when you edit this map");
    });


})


</script>

';
      
}

public function adminController(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 
 

        $nameFromPost = $_POST['namemap'];
    
        $namemap = strtolower(str_replace(' ', '-', $nameFromPost));
        $idmap = strtolower(str_replace(' ', '', $nameFromPost));
    
        $localization = $_POST['localization'];
        $zoom = $_POST['zoom'];
    
        $localizationPoint = $_POST['localizationpoint'];
      
             $showpopup = $_POST['showpopup'];
 

        $popupcontent = $_POST['popupcontent'];
        $height = $_POST['height'];
        $mousescroll = $_POST['mousescroll'];
    
        // Set up the data
        $data = "
    
    
        <div id='".$namemap."' style='height:".$height."'></div>
       
        <script src='".$this->domainPath()."js/leaflet.js'></script>
    
        <script>
        let ".$idmap." = L.map('".$namemap."', {
            center: [".$localization."],
            zoom:".$zoom.",
            scrollWheelZoom:".$mousescroll.",
         
        });
    
        ";
    
    foreach( $localizationPoint as $key => $n ) {
    
        $data .= "L.marker([".$n."]).addTo(".$idmap.")";
    
 
        if($showpopup[$key] == "on"){
        
            $data .=".bindPopup(`".$popupcontent[$key]."`,{autoClose:false}).openPopup();";
    
        };

     
    };
    
    $data .="	;L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap',
        }).addTo(".$idmap.");
        </script>";
    
    $folder        = PATH_PLUGINS.'mapCreator/mapCreated/';
    $filename      = $folder . $namemap.'.txt';
    $chmod_mode    = 0755;
    $folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
     
    if ($folder_exists) {
      file_put_contents($filename, $data);
    }
    
    


    };


}
 

 

    public function adminSidebar()
    {
        $pluginName = Text::lowercase(__CLASS__);
        $url = HTML_PATH_ADMIN_ROOT.'plugin/'.$pluginName;
        $html = '<a id="current-version" class="nav-link" href="'.$url.'">MapCreator Settings</a>';
        return $html;
    }


}


 

    function getMapCreator($map){
global $plugins;
        if($plugins['all']['mapCreator']->installed()){
         
            $path = PATH_PLUGINS.'mapCreator/mapCreated/'.$map.'.txt';
            echo file_get_contents($path);
        }
    }



?>