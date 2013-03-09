<?php
/**
 * Mustache application component
 * 
 * @author Bryan Gruneberg <bryan@perceptum.biz>
 *
 */
class EMustacheApplicationComponent extends CApplicationComponent
{
    /**
    * @var string the extension name of the view file. Defaults to '.php'.
    */
    public $fileExtension='.mustache';
    public $mustachePathAlias='ext.emustache.vendor.Mustache.src.Mustache';
    public $templatePathAlias = 'application.views';
    
    public $mustacheOptions=array();
    
    protected $_m;
    
    public function init()
    {
            // Unregister Yii autoloader
            spl_autoload_unregister(array('YiiBase','autoload'));
 
            // Register Mustache autoloader
            require Yii::getPathOfAlias($this->mustachePathAlias).'/Autoloader.php';
            Mustache_Autoloader::register(Yii::getPathOfAlias($this->mustachePathAlias).DIRECTORY_SEPARATOR.'..');
 
            // Add Yii autoloader again
            spl_autoload_register(array('YiiBase','autoload'));

            $this->_m = new Mustache_Engine(CMap::mergeArray(
                    array(
                        'cache' => Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'Mustache'.DIRECTORY_SEPARATOR.'cache',
                        'partials_loader' => new Mustache_Loader_FilesystemLoader(Yii::getPathOfAlias($this->templatePathAlias),
                            array('extension' => $this->fileExtension)),
                        'escape' => function($value) {
                            return CHtml::encode($value);
                        },
                        'charset' => Yii::app()->charset,
                    ),$this->mustacheOptions)
            );
    }
}
