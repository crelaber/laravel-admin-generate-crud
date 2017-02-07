<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/11/18
 * Time: 15:21
 */
namespace App\Generate\helper;

class GenerateHelperBak {

    /**
     * 生成各类文件接口
     * @param $config array 配置参数
     */
    public function generate($config = []){
        $configs = config('generate.db_config');
        if(count($configs) == 0){
            echo 'empty config';
            die(0);
        }
//        $configs = $this->getConfig();
        foreach ($configs as $config){
            $this->writeModelStubContent($config);
            $this->writeRepoStubContent($config);
            $this->writeFacadeStubContent($config);
            $this->writeControllerStubContent($config);
        }
        echo 1;
    }

    /**
     * 生成Model类文件方法
     * @param $config array 配置参数
     */
    protected function writeModelStubContent($config){
        $config['fill_columns'] = $this->getModelColumns($config);
        $stubFile = $this->getFullStubPath(config('generate.generate_dir'),'model.stub');
        $content = $this->readFile($stubFile);
        $replacement = $this->getReplaceParams($config,'model');
        $content = $this->replaceContent($content,$replacement);
        //格式化Model文件
        $modelPrefix = $this->formatModelName($config['model_name']);
        $fileName = $this->getWriteFileName($config['model_name'],'');
        $outputFile = $this->getWriteFilePath(config('generate.models_dir'),$fileName);
        $this->writeContent($outputFile,$content);
    }

    /**
     * 生成Facade类文件方法
     * @param $config array 配置参数
     */
    protected function writeFacadeStubContent($config){
        $stubFile = $this->getFullStubPath(config('generate.generate_dir'),'facade.stub');
        $content = $this->readFile($stubFile);
        $replacement = $this->getReplaceParams($config,'facade');
        $content = $this->replaceContent($content,$replacement);
        //格式化Model文件
        $modelPrefix = $this->formatModelName($config['model_name']);
        $fileName = $this->getWriteFileName($config['model_name'],'Facade');
        $outputFile = $this->getWriteFilePath(config('generate.facades_dir'),$fileName);
        $this->writeContent($outputFile,$content);
    }

    /**
     * 生成Controller类文件方法
     * @param $config array 配置参数
     */
    protected function writeControllerStubContent($config){
        $config['grid_content'] = $this->getGridContent($config);
        $config['form_content'] = $this->getFormContent($config);
        $stubFile = $this->getFullStubPath(config('generate.generate_dir'),'controller.stub');
        $content = $this->readFile($stubFile);
        $replacement = $this->getReplaceParams($config,'controller');
        $content = $this->replaceContent($content,$replacement);
        $modelPrefix = $this->formatModelName($config['model_name']);
        $fileName = $this->getWriteFileName($modelPrefix,'Controller');
        $outputFile = $this->getWriteFilePath(config('generate.controller_dir'),$fileName);
        $this->writeContent($outputFile,$content);
    }

    /**
     * 生成Repo文件方法
     * @param $config array 配置参数
     */
    protected function writeRepoStubContent($config){
        $stubFile = $this->getFullStubPath(config('generate.generate_dir'),'repository.stub');
        $content = $this->readFile($stubFile);
        $replacement = $this->getReplaceParams($config,'repo');
        $content = $this->replaceContent($content,$replacement);
        //格式化Model文件
        $modelPrefix = $this->formatModelName($config['model_name']);
        $fileName = $this->getWriteFileName($modelPrefix,'Repository');
        $outputFile = $this->getWriteFilePath(config('generate.repos_dir'),$fileName);
        $this->writeContent($outputFile,$content);
    }

    /**
     * 获取要写入的文件的路径
     * @param $dir string 目录
     * @param $fileName string 文件名称
     * @return string
     */
    protected function getWriteFilePath($dir,$fileName){
        return getBasePath().$dir.'/'.$fileName;
    }

    /**
     * 获取模版文件路径
     * @param $dir string 目录
     * @param $stubname string stub文件名称
     * @return string
     */
    protected function getFullStubPath($dir,$stubname){
        return getBasePath().$dir.'/stub/'.$stubname;
    }

    /**
     * 获取要写入的文件的全路径
     * @param $prefix string 文件前缀
     * @param $type string 类型
     * @param $suffix string 文件后最
     * @return array
     */
    protected static function getWriteFileName($prefix,$type,$suffix='.php'){
        return $prefix . $type . $suffix;
    }

    /**
     * 获取要替换的操作类的配置
     * @param $config array 配置数组
     * @param $type string 类型
     * @return array
     */
    protected function getReplaceParams($config, $type){
        $replacement = [];
        switch ($type){
            case 'model' :
                $replacement = [
                    array(
                        'search'=>'${MODEL_NAME}',
                        'replace' => $config['model_name']
                    ),
                    array(
                        'search'=>'${TABLE_NAME}',
                        'replace' => $config['table_name']
                    ),
                    array(
                        'search'=>'${COLUMNS}',
                        'replace' => $config['fill_columns']
                    ),
                ];
                break;
            case 'repo' :
                $replacement = [
                    array(
                        'search'=>'${MODEL_NAME}',
                        'replace' => $config['model_name']
                    ),
                    array(
                        'search' =>'${INFO_CACHE_KEY}',
                        'replace' =>$config['info_cache_key']
                    ),
                    array(
                        'search' =>'${CACHE_TAG}',
                        'replace' =>$config['cache_tag']
                    ),
                    array(
                        'search' =>'${CAHCE_TIME_KEY}',
                        'replace' =>$config['cache_time_key']
                    )
                ];
                break;
            case 'facade' :
                $replacement = [
                    array(
                        'search'=>'${MODEL_NAME}',
                        'replace' => $config['model_name']
                    ),
                ];
                break;
            case 'controller' :
                $replacement = [
                    array(
                        'search'=>'${MODEL_NAME}',
                        'replace' => $config['model_name']
                    ),
                    array(
                        'search'=>'${TABLE_NAME}',
                        'replace' => $config['table_name']
                    ),
                    array(
                        'search'=>'${GRID_CONTENT}',
                        'replace' => $config['grid_content']
                    ),
                    array(
                        'search'=>'${FORM_CONTENT}',
                        'replace' => $config['form_content']
                    ),
                ];
                break;

        }
        return $replacement;
    }

    /**
     * 读取文件并返回内容
     * @param $file string 文件名
     * @return string
     */
    protected function readFile($file){
        $content = file_get_contents($file);
        return $content;
    }

    /**
     * 替换内容
     * @param $content string 原始内容
     * @param $replaces array 要替换的内容数组
     * @return string
     */
    protected function replaceContent($content,$replaces){
        $result = '';
        if(!is_array($replaces)){
            return $result;
        }
        foreach ($replaces as $key => $val){
            $content = str_replace($val['search'],$val['replace'],$content);
        }
        return $content;
    }

    /**
     * 写内容到文件
     * @param $content string 原始内容
     * @param $file string 文件名
     */
    protected function writeContent($file,$content){
        file_put_contents($file,$content);
    }

    /**
     * 格式化model文件的名称
     * @param $modelName string 原始内容
     * @return string
     */
    protected function formatModelName($modelName){
//        $modelName = strtolower($modelName);
//        $firstLetter = substr($modelName,0,1);
//        $otherLetters = substr($modelName,1);
//        return strtoupper($firstLetter).$otherLetters;
        return $modelName;
    }

    /**
     * 获取控制器列表内容
     * @param $config array 配置数组
     * @return string
     */
    protected function getGridContent($config){
        $table_columns = $config['table_columns'];
        $arr = explode(',',$table_columns);
        $content = '';
        if(!$arr){
            return $content;
        }
        foreach ($arr as $column){
            $column = "trans('backend.\${TABLE_NAME}.column.'".$column.")";
            $content .= '$grid->'.$column."('".$column."');"."\n";
        }
        return $content;
    }

    /**
     * 获取控制器Form表单内容
     * @param $config array 配置数组
     * @return string
     */
    protected function getFormContent($config){
        $table_columns = $config['table_columns'];
        $arr = explode(',',$table_columns);
        $content = '';
        if(!$arr){
            return $content;
        }
        foreach ($arr as $column){
            $content .=  '$form->text("'.$column.'");'."\n";
        }
        return $content;
    }
    /**
     * 获取控制器Form表单内容
     * @param $config array 配置数组
     * @return string
     */
    protected function getModelColumns($config){
        $table_columns = $config['table_columns'];
        $arr = explode(',',$table_columns);
        $content = '';
        if(!$arr){
            return $content;
        }
        $columns= [];
        foreach ($arr as $column){
            $column = "'".$column."'";
            array_push($columns,$column);
        }
        return implode(',',$columns);
    }

    protected function getConfig(){
        return [
            [
                'table_name' => 'testing_advice', //表名
                'model_name' => 'Advices', //model名
                'table_columns' => 'id,tid,range_value,operate_type,note',  //表对应的列
                'info_cache_key' => 'testing.advice.info', //详情缓存信息key
                'cache_time_key' => 'testing.common_cache_time', //详情缓存信息key
                'cache_tag' => 'testing.advice', //redis缓存对应的 tag
            ],
            [
                'table_name' => 'testing_advice', //表名
                'model_name' => 'AdvicesTTT', //model名
                'table_columns' => 'id,tid,range_value,operate_type,note',  //表对应的列
                'info_cache_key' => 'testing.advice.info', //详情缓存信息key
                'cache_time_key' => 'testing.common_cache_time', //详情缓存信息key
                'cache_tag' => 'testing.advice', //redis缓存对应的 tag
            ],
            [
                'table_name' => 'testing_advice', //表名
                'model_name' => 'AdvicesRRR', //model名
                'table_columns' => 'id,tid,range_value,operate_type,note',  //表对应的列
                'info_cache_key' => 'testing.advice.info', //详情缓存信息key
                'cache_time_key' => 'testing.common_cache_time', //详情缓存信息key
                'cache_tag' => 'testing.advice', //redis缓存对应的 tag
            ]
        ];
    }
}