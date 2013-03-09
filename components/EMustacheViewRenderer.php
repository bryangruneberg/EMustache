<?php
/**
 * Mustache view renderer for the Yii PHP framework
 * 
 * @author Johannes "Haensel" Bauer <thehaensel@gmail.com>
 *
 * Changed by Bryan Gruneberg <bryan@perceptum.biz> to extend and appplication component instead
 */
class EMustacheViewRenderer extends EMustacheApplicationComponent implements IViewRenderer
{
    /**
    * Renders a view file.
    * This method is required by {@link IViewRenderer}.
    * @param CBaseController $context the controller or widget who is rendering the view file.
    * @param string $sourceFile the view file path
    * @param mixed $data the data to be passed to the view
    * @param boolean $return whether the rendering result should be returned
    * @return mixed the rendering result, or null if the rendering result is not needed.
    */
    public function renderFile($context,$sourceFile,$data,$return)
    {
            if(!is_file($sourceFile) || ($file=realpath($sourceFile))===false)
                    throw new CException(Yii::t('yii','View file "{file}" does not exist.',array('{file}'=>$sourceFile)));

            $rendered=$this->_m->render(file_get_contents($sourceFile),$data);
            
            if($return)
            {
                return $rendered;
            }
            else
                echo $rendered;
    }
}
