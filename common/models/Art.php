<?php

namespace common\models;
use common\models\Category;
use Yii;
use common\models\ArtSearch;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "art".
 *
 * @property integer $id
 * @property string $id_bl
 * @property string $created_at
 * @property string $country
 * @property string $city
 * @property string $category
 * @property string $sub_category
 * @property integer $votes
 * @property string $author
 * @property string $title
 * @property integer $total_pending_payout_value
 * @property integer $replies
 * @property string $body
 * @property string $meta
 * @property string $lang

 */
class Art extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'art';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['votes', 'total_pending_payout_value', 'replies'], 'integer'],
            [['body', 'meta'], 'string'],
            [['id_bl'], 'string', 'max' => 11],
            [['country', 'city', 'category', 'sub_category', 'author', 'title'], 'string', 'max' => 20],
            [['lang'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_bl' => 'Id Bl',
            'created_at' => 'Created at',
            'country' => 'Country',
            'city' => 'City',
            'category' => 'Category',
            'sub_category' => 'Sub Category',
            'votes' => 'Votes',
            'author' => 'Author',
            'title' => 'Title',
            'total_pending_payout_value' => 'Total Payot Value',
            'replies' => 'Replies',
            'body' => 'Body',
            'meta' => 'Meta',
            'lang' => 'Lang',
          
        ];
    }
    
    
       
    
    static function create_array_categories($raw = null)
    {
        $data_full = null;
        $query = new Category();
        
            $array_categories = $query->find()->asArray()->select('country_json, city_json, category_json, sub_category_json')->all();
            foreach ($array_categories as $line){
                $country_json = json_decode($line['country_json'], true);
                if ($country_json['text']!='null'){
                    $data_full[]= $country_json;
                }
                $city_json = json_decode($line['city_json'], true);
                foreach ($city_json as $city_js){
                    if ($city_js['text']!='null'){
                        $data_full[]= $city_js;
                    }
                }
                $category_json = json_decode($line['category_json'], true);
                foreach ($category_json as $cat_js){
                    if ($cat_js['text']!='null'){
                        $data_full[]= $cat_js;
                    }
                }
                $sub_category_json = json_decode($line['sub_category_json'], true);
                foreach ($sub_category_json as $sub_cat_js){
                    if ($sub_cat_js['text']!='null'){
                        $data_full[]= $sub_cat_js;
                    }
                }
                    
                
                
            }
         
        
        
        return $data_full;
   
        
        }
        
        
   
   
   
        static function clean_data($category){
            
        $category = str_replace("\"", "", $category);
        $category = str_replace("[", "", $category);
        $category = str_replace("]", "", $category);
         
        if (strpos($category, "+") > 0) {
            $category = explode('+', $category);
        } else if (strpos($category, " ") > 0) {
            $category = explode(" ", $category);
        }
        
        return $category;
        }
        
        //This function use for get first image to preview from Thumbs folder
         static function get_images($model){
           $meta = $model->meta;
           $meta = json_decode(stripslashes($meta), true);
           $image = $model->validate_json($meta, 'image');
            if ($image[0]){
                $image = '\storage/web/thumbs/' . $model->permlink . '-' . basename($image[0]);
                return $image;
                
            } else {
                return false;
            }
          
        }
        
        
        //This function use for clean and replace images links in preview
        static function get_images_links_for_clean_preview($model){
           $meta = $model->meta;
           $meta = json_decode(stripslashes($meta), true);
           $image = $model->validate_json($meta, 'image');
            if ($image[0]){
                return $image;
                
            } else {
                return false;
            }
          
        }
        
        static function get_links($model){
            $meta = $model->meta;
            $meta = json_decode(stripslashes($meta), true);
            $links = $model->validate_json($meta, 'links');
            if ($links){
                return $links;
                
            } else {
                return false;
            }
            
        }
        
        static function validate_json($meta, $arg){
            
            if (is_array($meta)&&(isset($meta[$arg][0]))){ //проверяем на существование и на массив/строку
                if (is_array($meta[$arg]))
                    return $meta[$arg];

                elseif (is_string($meta[$arg]))
                    $array_meta[$arg][] = $meta[$arg];
                    return $array_meta;                  
                
            } else {
                return false;
            }
            
            
        }
        
        /*
         * This function clean text for first line each item
         */
        static function get_first_line($model){
//                $links = $model::get_links($model);
                $first_line = StringHelper::truncate($model->body, 250, '...', null, true);
                $matches = Art::parse_links_and_urls($first_line);
               
                foreach($matches[0] AS $m){
                    $first_line = str_replace($m,'',$first_line);
                
               }
                $first_line = str_replace("\\n\\n", ". ", $first_line);
                $first_line = strip_tags($first_line);
                $first_line= preg_replace('/[^a-zа-яё\s.,]+/iu', '', $first_line);
        
              return $first_line;
        }
        
        
        
        static function get_body($model){
            
            $format_img = ['jpg','png','gif','jpeg','swf','bmp','tiff','tipp'];
            $body = $model->body;
            $matches = Art::parse_links_and_urls($body);
            foreach($matches[0] as $id => $m){
                if (in_array($matches[4][$id], $format_img)){
                    $body = str_replace($m,'![]('. $m . '){.body_images}', $body);
                } else {
                    $body = str_replace($m,'[' . $m . ']('. $m . ')', $body);
               
                    
                }
                
           }
           return $body;
        }
        
        
        
        /*
         * This function parse all links and images and return in array for cleaning or change
         */
        static function parse_links_and_urls($text){
           $re = '/(([A-Za-z.-_]+)\.([\/.A-Za-z0-9-_#=&;%+]{0,})\.([\/.A-Za-z0-9-_#=&;%+]{0,}))/';
            preg_match_all($re, $text, $matches);
            return $matches;
           
        }
        
        
        
        /*
         * Функция делает выборку статей из базы по ключевым тегам категорий. Категории передаются в формате
         * cat1+cat2+cat3 (string).
         */
        
        static function get_data_by_categories($categories = null){
             $searchModel = new ArtSearch();
                
             if ($categories == null){
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
             }
             else {
                 $categories = Art::clean_data($categories);
                 $count = count($categories);
                 if ($count == 1) {
                     
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories]]);
                     $count1 = $dataProvider->getTotalCount(); 
                     /* Этот код написан для того, чтобы использовать адресную строку для задания критериев поиска по категории
                     * В адресной строке можно передавать страны, города, или одни лишь категории, а нижеследующий код побирает им свои места (работает для 1 категории) 
                     */ 
                     if ($dataProvider->getTotalCount() === 0) {
                            $searchModel = new ArtSearch();
                           $dataProvider = $searchModel->search([$searchModel->formName() => ['city' => $categories]]);
                             if ($dataProvider->getTotalCount() === 0) {
                                  $searchModel = new ArtSearch();
                                 $dataProvider = $searchModel->search([$searchModel->formName() => ['category' => $categories]]);
                             }
                     }

            } else if ($count == 2) {
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories[0], 'city' => $categories[1]]]);
                 } else if ($count == 3) {
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories[0], 'city' => $categories[1], 'category' => $categories[2]]]);
                 } else if ($count == 4) {
                     $dataProvider = $searchModel->search([$searchModel->formName() => ['country' => $categories[0], 'city' => $categories[1], 'category' => $categories[2], 'sub_category' => $categories[3]]]);
                 }
                 
             }
             $dataProvider->sort = [
                'defaultOrder' => ['created_at' => SORT_DESC]
             ];
                    
                    
            return $dataProvider;
            
        }
        
        
        static function get_author_categories($author){
            if ($author == null) {
                 $author = Yii::$app->user->identity->username;
            }
            return $raw = (new \yii\db\Query())
                ->select('country,city,category,sub_category')
                ->from(['Art'])
                ->where('author=' . "'" .  $author . "'")
                ->all();
            
        }
        
        
        static function get_single_blog($author = null){
            $searchModel = new ArtSearch();
            
            if ($author == null) {
                 $author = Yii::$app->user->identity->username;
            }
            $dataProvider = $searchModel->search([$searchModel->formName() => ['author' => $author]]);
            $dataProvider->sort = [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ];
            return $dataProvider;


        }
            
        static function get_single_art($author, $permlink){
            
        $model = Art::find()->where(['author' => $author])->andWhere(['permlink' => $permlink])->one();
        return $model;

        }
            
        
        
        
        
        
        
        
        
        
}
