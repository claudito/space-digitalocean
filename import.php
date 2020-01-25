<?php 

include '../vendor/autoload.php';

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;


$filename    =  $_FILES['archivo']['name']; //Nombre del Archivo
$extension   =  pathinfo($_FILES['archivo']['name'],PATHINFO_EXTENSION);//Extensión del Archivo
$filename    =  "nuevo_nombre".$extension;//Nombre del Archivo con nuevo nombre

$destination =  $_FILES['archivo']['tmp_name'];//Ruta Temporal
$endpoint    =  "https://fra1.digitaloceanspaces.com";//End Point: Considerar el prefijp https://
$folder      =  "imagenes/"; //Folder que se creara en dentro del Space
$space       =  "spacecloud"; //Nombre del Space
$permiso     =  "public-read"; //Permiso de Lectura Habilitado

try {
	
//Configuracíón
$client = new S3Client([
    'credentials' => [
        'key'    => 'your-key',//key
        'secret' => 'your-secret',//secret
    ],
    'region' 	=> 'fra1',//Region
    'version' 	=> 'latest',//version
    'endpoint' 	=> $endpoint, //endpoint
]);

//Subimo el archivo
 $result = $client->putObject([

            'Bucket'     => $space,//space
            'Key'        => $folder.$filename, //Ubicación del Archivo en tu Space
            'SourceFile' => $destination, //ruta temporal del archivo
             'ACL'       => $permiso // indicamos que se subira en modo publico, si quitamos en esta linea se subira en modo privado
       


        ]);


 echo $result;



} catch (Exception $e) {

echo "Error: ".$e->getMessage();
	
}




 ?>
