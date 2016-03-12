<?php

namespace app\models;
use Yii;
/**
 * This is the model class for table "hl_user_relation".
 *
 * @property integer $user_id
 * @property integer $parent_id
 * @property integer $level_id
 * @property integer $create_time
 */
class UserRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hl_user_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'parent_id'], 'required'],
            [['user_id', 'parent_id','create_time'], 'integer']
        ];
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'parent_id']);
    }

      public function getUsert()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'parent_id' => 'Parent ID',
            'create_time' => 'Create Time',
        ];
    }

    public function ListTreeUser($user_id){
        $res = $this->getTreeUser($user_id);


        $tree_list = $this->MultiArrayToSimple($res);


        return $tree_list;
    }

    public function getTreeData($user_id = 0){

        $data = $this->getChildren($user_id);
        $i = 0;
        foreach ($data as $key) {


            $data[$i]['text'] = $key['nickname'] ? $key['nickname'] : $key['account'] . "(账户)";

            //$data[$i]['state']['expanded'] = true;

            $res = $this->getTreeData($key['user_id']);
            //unset($data[$i]['user_id']);
            unset($data[$i]['nickname']);
            //unset($data[$i]['parent_id']);
            unset($data[$i]['create_time']);
            if($res){
                $data[$i]['nodes'] = $res;
            }


            $i = $i+1;
        }



        return $data;
    }

    /**
     * 多维数组转二维数组
     *
     * @param $multi_arr
     * @return array|null
     */
    public function MultiArrayToSimple($multi_arr){
        if($multi_arr){
            static $tree_list = [];

            if($multi_arr){
                foreach($multi_arr as $k=>$v){
                    if(isset($v['user_id'])){
                        $tree_list[] = $v;
                    }else{
                        $this->ListTreeUser($v);
                    }

                }
            }
            return $tree_list;
        }else{
            return null;
        }

    }


    /**
     * @param $user_id
     * @return array 返回用户下线数组（带组织结构）
     */
    public function getTreeUser($user_id){

        $res = $this->getChildren($user_id);

        $child = [];
        if($res){
            foreach($res as $k=>$v){
                if($v['user_id']){
                    $child_res = $this->getTreeUser($v['user_id']);
                    if($child_res){
                        $child[] = $child_res;
                    }

                }
            }
        }

        $res = array_merge($res,$child);

        return $res;
    }


    /**
     * 获取用户下线
     * @param $user_id
     * @return array 返回下线
     */
    public function getChildren($user_id){
        $query = $this->find();

        $query->select("hl_user_relation.*,u.nickname,u.account");



        $query->andFilterWhere(['hl_user_relation.parent_id'=>$user_id]);
        $query->leftJoin(['u'=>'hl_user'],'u.user_id=hl_user_relation.user_id');
        $res = $query->asArray()->all();

        return $res;
    }

    /**
     * 获取下线信息
     *
     * @param $user_id
     * @param array $option
     * @return array|\yii\db\ActiveRecord[] 返回下线（数组）
     */
    public function getChilds($user_id,$option = []){
        $query = $this->find();

        $query->select("*,u.user_id,u.nickname,u.account,u.phone,u.create_time,u.status,l.name as l_name")
            ->leftJoin('hl_user as u','u.user_id = hl_user_relation.user_id')
            ->leftJoin('hl_level as l','l.level_id = u.level_id');

        $query->where(['hl_user_relation.parent_id'=>$user_id])->andwhere('u.user_id = hl_user_relation.user_id');

        if($option){

            //筛选等级
            if(isset($option['level_id']) && $option['level_id']){
                $query->andWhere(['l.level_id'=>(int)$option['level_id']]);
            }


            //搜索
            if(isset($option['search']) && $option['search']){
                $search = $option['search'];
                $search_num = (int)$search;
                $query->andWhere("u.user_id = $search_num OR u.account LIKE '%$search%' OR u.nickname LIKE '%$search%'");

            }

        }
        return $query;
    }

    /**
     * 获取改用户最新交易中订单的一条信息
     * @param $user_id
     *  @return string
     */

    public function  getMoney($user_id){
        $time = Payhelp::find()->where(['user_id'=>$user_id,'status'=>1])->max('create_time'); 
        $res =  Payhelp::find()->where(['user_id'=>$user_id,'create_time'=>$time,'status'=>1])->asArray()->one(); 
        return $res['money'];
    }

    /**
     *  获取改用户最新订单的一条信息
     *  @param $user_id
     *  @return string
     */
      public function  getFinishMoney($user_id){
        $time = Payhelp::find()->where(['user_id'=>$user_id,'status'=>3])->max('create_time'); 
        $res = Payhelp::find()->where(['user_id'=>$user_id,'status'=>3,'create_time'=>$time])->asArray()->one(); 
        return $res['money'];
    }


       /**
     *  获取改用户第二条已经完成的订单金额
     *  @param $user_id
     *  @return string
     */
      public function  getFinishSecondMoney($user_id){
        $res = [];
        $payhelp = Payhelp::find()->where(['user_id'=>$user_id,'status'=>3])->orderBy('create_time')->asArray()->all(); 
        if(isset($payhelp)){
            if(isset($payhelp[1])){
               $res = Payhelp::find()->where(['user_id'=>$user_id,'status'=>3,'create_time'=>$payhelp[1]['create_time']])->asArray()->one(); 
            }
        }
        return $res;
    }


    /**
    *   查询该用户的推荐人 既是父级id
     *  @param $user_id
     *  @return string
     */

    public function getParent_id($user_id){
       $parent =  UserRelation::find()->where(['user_id'=>$user_id])->asArray()->one();
       return $parent['parent_id'];
    }


    /**
     *  获取用户上个月的提供帮助的交易总额
     *  @param $user_id
     *  @return string 
     */
    
    public function getPreMonthMoney($user_id){
        $month_money  = Payhelp::find()->where('create_time >= :a and create_time<=:b and user_id=:c',[':a'=>pre_monthstar(),':b'=>pre_monthend(),':c'=>$user_id])->sum('money');
        return $month_money;
    }

    /**
     *  获取用户当月的提供帮助的交易总额
     *  @param $user_id
     *  @return  string 
     */
    
    public function getMonthMoney($user_id){
        $month_money  = Payhelp::find()->where('create_time >= :a and create_time<=:b and user_id=:c',[':a'=>monthstar(),':b'=>monthend(),':c'=>$user_id])->sum('money');
        return $month_money;
    }

    /**
     *  获取用户的等级信息
      *  @param $user_id
     *   @return array（数组） 
     */
     public function getLevel($user_id){
        $user  = User::findOne($user_id);
        $level = Level::find()->where(['level_id'=>$user->level_id])->asArray()->one();
        $level['commission']   = json_decode($level['commission'],true)['num'];
        return $level;
    }


    /**
     * 当该用户提供帮助时 把钱加给上线的 推荐奖金待定钱包或者经理待定钱包 待定金额
     * @param  $user_id 用户id
     * @return int
     */
    public $count = 0;
    public function getPendingChildrenMoney($user_id){
        //父级id
        $parent_id = (int)$this->getParent_id($user_id);
        if($parent_id !==0){
            $this->count += 1;
            // 获取改用户最新未完成的订单的一条信息
            $money = $this->getMoney($user_id);
            // 获取改用户最新的已经完成的订单的一条信息
            $finish_money = $this->getFinishMoney($user_id);
             // 获取改用户父级 当月最新提供帮助的交易总额
            $month_money = $this->getMonthMoney($parent_id);
             // 取改用户父级 上个月 提供帮助的交易总额
            $pre_month_money = $this->getPreMonthMoney($parent_id);
            //父级等级
            $level = $this->getLevel($parent_id);
            //判断父级的佣金代数是否存在
            if(isset($level['commission'][ $this->count-1])){
                $getmoney = $money * $level['commission'][ $this->count-1]/100;
                    //判断$count =1 既为第一代   
                    if( $this->count ==1){
                        //判断 下级一个会员投资额度减少，对该会员的佣金减少额度（%）：
                        if($money < $finish_money){
                            $get_money  = $getmoney *(1-$level['next_money_less']/100);
                        }
                    }
                //父级用户信息   
                $user = User::findOne($parent_id);
                //月投资金额减少，扣除本月佣金奖励额度（%）：
                if($month_money < $pre_month_money){
                    $getmoney  =  $getmoney*(1-$level['month_money_less']/100);
                }
                //判断奖金类型
                 if($level['bonus_type']==1){
                    //推荐奖金钱包
                    $user->money_rec =  $user->money_rec + ceil($getmoney);
                }else if($level['bonus_type']==2){
                    //经理奖金待定钱包
                    $user->money_manager =  $user->money_manager + ceil($getmoney);
                }
                //将佣金存入到 待定钱包里面去
                $user->save();
            }
            return  $this->getPendingChildrenMoney($parent_id);
        }else{
            return $parent_id;
        }
    }

    /**
     *当该用户提供帮助订单完成时 把钱加给上线的 推荐奖金流动钱包或者经理流动钱包
    *  @param  $user_id 用户id
     * @return int
     */

     public function getChildrenMoney($user_id){
          //父级id
        $parent_id = (int)$this->getParent_id($user_id);
        if($parent_id !==0){
            $this->count += 1;
            // 获取改用户最新的已经完成的订单的一条信息
            $money = $this->getFinishMoney($user_id);
            // 获取改用户最新第二条完成的订单的一条信息
            $second_money = $this->getFinishSecondMoney($user_id);
            if(!empty($second_money)){
                $second_money = $second_money['money'];   
            }else{
             // 获取改用户父级 当月最新提供帮助的交易总额
                $second_money = 0;
            }
            $month_money = $this->getMonthMoney($parent_id);
             // 取改用户父级 上个月 提供帮助的交易总额
            $pre_month_money = $this->getPreMonthMoney($parent_id);
            //父级等级
            $level = $this->getLevel($parent_id);
            //判断父级的佣金代数是否存在
            if(isset($level['commission'][ $this->count-1])){
                $getmoney = $money * $level['commission'][ $this->count-1]/100;
                    //判断$count =1 既为第一代   
                    if( $this->count ==1){
                        //判断 下级一个会员投资额度减少，对该会员的佣金减少额度（%）：
                        if($money < $second_money){
                            $getmoney  = $getmoney *(1-$level['next_money_less']/100);
                        }
                    }
                //父级用户信息   
                $user = User::findOne($parent_id);
                //月投资金额减少，扣除本月佣金奖励额度（%）：
                if($month_money < $pre_month_money){
                    $getmoney  =  $getmoney*(1-$level['month_money_less']/100);
                }
                //判断奖金类型
                 if($level['bonus_type']==1){
                    //推荐奖金钱包
                    $user->money_rec =  $user->money_rec - ceil($getmoney);
                    $user->flow_money_rec =  $user->flow_money_rec + ceil($getmoney);
                }else if($level['bonus_type']==2){
                    //经理奖金待定钱包
                    $user->money_manager =  $user->money_manager -ceil($getmoney);
                    //经理奖金流动钱包
                    $user->flow_money_manager =  $user->flow_money_manager +  ceil($getmoney);
                }
                //将佣金存入到 待定钱包里面去
                $user->save();
            }
            return  $this->getChildrenMoney($parent_id);
        }else{
            return $parent_id;
        }
     }
}
