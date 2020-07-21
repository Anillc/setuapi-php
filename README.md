# setuapi-php  

这是 [setuapi-cf](https://github.com/Aillc/setuapi-cf) 的php版本  
采用文件保存GitHub api的结果  

图源 [laosepi/setu](https://github.com/laosepi/setu)  

部署:  
下载releases中的文件然后丢php空间上  
注：需要开启url rewriting，参考.htaccess  

routes:  
1. /refresh 该接口会刷新setu.json，在部署完成后需要执行一次    
2. /setu 获取一张涩图(由服务器转发)  
3. /setu! 获取一张涩图(302跳转到jsDeliver)  

build:  
1. `git clone https://github.com/Anillc/setuapi-php.git`  
2. `cd setuapi-php && composer install`