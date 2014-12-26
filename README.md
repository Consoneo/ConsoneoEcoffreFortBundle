ConsoneoECoffreFortBundle
=========================

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6b4a0b60-3466-4041-8a68-5df0388428b8/mini.png)](https://insight.sensiolabs.com/projects/6b4a0b60-3466-4041-8a68-5df0388428b8)

Installation
-------------------------

To install ConsoneoEcoffreFortBundle with Composer just add the following to your 'composer.json' file:

    {
        require: {
            "consoneo/ecoffre-fort-bundle": "*",
            ...
        }
    }

The next thing you should do is install the bundle by executing the following command:

    php composer.phar update consoneo/ecoffre-fort-bundle
    
Finally, add the bundle to the registerBundles function of the AppKernel class in the 'app/AppKernel.php' file:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Consoneo\Bundle\EcoffreFortBundle\ConsoneoEcoffreFortBundle(),
            ...
        );
        
Configuration
-------------------------

Configure the bundle by adding the following to app/config/config.yml' with your own configuration:

    consoneo_ecoffre_fort:
        coffres:
            coffre1:
                email_origin:         xxx
                safe_id:              xxx
                part_id:              xxx
                password:             xxx
    
            coffre2:
                email_origin:         xxx
                safe_id:              xxx
                part_id:              xxx
                password:             xxx
                
The Coffre map
-------------------------
You can access all declared coffres throught the map service. In the previous exemple, we declared a `coffre1 coffre :

    $this->container->get('ecoffrefort.coffre_map')->get('coffre1');

Usage
-------------------------

Each Coffre of ConsoneoEcoffreFortBundle support following methods : 

### putFile (API de Dépôt)
### getFile (API de Consultation)
### removeFile (API de Suppression)
### getCert (API de récupération du certificat de conformité)
### moveFile (API de déplacement d'un document)
