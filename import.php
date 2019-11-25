<?php 

include'vendor/autoload.php';

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;


try {


$nombre    =  $_FILES['archivo']['name']; //nombre del archivo
$ubicacion =  $_FILES['archivo']['tmp_name']; //ruta temporal del archivo

$client = new S3Client([
    'credentials' => [
        'key'    => 'KEY',//Generado en el administrador de los Spaces
        'secret' => 'SECRET', //Generado en el administrador de los Spaces
    ],
    'region'   => 'nyc3', //Region donde se crea el space
    'version'  => 'latest',//Significa que estamos utilizamos la última versión
    'endpoint' => 'https://perutec.nyc3.digitaloceanspaces.com', //Nombre del space que le colocamos al momnento de crearlo
]);

$adapter = new AwsS3Adapter($client, 'nombre.carpeta');//Nombre de la carpeta donde vamos a subir nuestro archivo(El nombre del archivo debe llevar un punto)

$filesystem = new Filesystem($adapter);


  $result = $client->putObject([

            'Bucket'     => 'nombre.carpeta', //Carpeta
            'Key'        => $nombre, //nombre del archivo
            'SourceFile' => $ubicacion, //ruta temporal del archivo
             'ACL'       => 'public-read' // indicamos que se subira en modo publico, si quitamos en esta linea se subira en modo privado

        ]);




} catch (Exception $e) {

echo "Error: ".$e->getMessage();

	
}




 ?>
