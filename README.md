### duoduoke_sdk

拼多多旗下多多客api-sdk

#### 下载

    composer require welcomecomli/duoduoke_demo
    
#### 使用
    laravel 框架为例子:
        
        //引入
        use duoduoke\duoduoke_demo\duoduoke_server_data;
        //实例化对象
        $this->duoduoke  = new duoduoke_server_data(['client_id'=>'123123','client_secret'=>'12312312']);
        
        //调用接口-多多进宝商品详情
        $result = $this->duoduoke->_ddk_theme_list("pdd.ddk.goods.detail",['goods_id'=>[123123123]]);
        //调用接口-多多进宝商品列表
        $data = $this->duoduoke->_ddk_theme_list('pdd.ddk.theme.list.get',array('page_size'=>5,'page'=>1));

    原生开发:
         
         use duoduoke\duoduoke_demo\duoduoke_server_data;
         
         require __DIR__ . '/vendor/autoload.php';
        
        //实例化对象
        $this->duoduoke  = new duoduoke_server_data(['client_id'=>'123123','client_secret'=>'12312312']);
        
        //调用接口-商品详情
        $result = $this->duoduoke->_ddk_theme_list("pdd.ddk.goods.detail",['goods_id'=>[123123123]]);

#### 文档
    
    <a href="http://open.pinduoduo.com/" rel="nofollow noindex noopener external">拼多多开放平台</a>
    


