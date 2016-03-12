安装说明：
	以 YII2 基础模板为例 （高级模板修改对应的命名空间即可）
将 ip文件夹 放入 根目录 common 下即可

使用说明：
	使用处头部加入  
		use app\common\ip\ipLocation;
	调用
		ipLocation::getIpName( ip地址 )
