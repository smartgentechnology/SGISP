<?php
/*
配置文件
公共配置文件

*/
defined('ACC')||exit('对不起！你无权访问！');//给当前文件上锁

/*top*/
$top_Comparison = 'Product Comparison';//产品对比
$top_Language = 'Language';//语言
$top_Menus = 'Menus';//菜单
$top_Search = 'Search';//搜索

/*menu*/
$menu_Products='Products';//产品分类
$menu_Products_B='PRODUCTS';//产品分类
$menu_Index='Index';//众智首页
$menu_Index_B='INDEX';//众智首页
$menu_Solutions='Solutions';//解决方案
$menu_Solutions_B='SOLUTIONS';//解决方案
$menu_Case='Application Cases';//应用案例
$menu_Download='Download';//资料下载
$menu_Download_B='DOWNLOAD';//资料下载
$menu_About='About Us';//关于众智
$menu_About_B='ABOUT US';//关于众智
$menu_Profile='Profile';//众智介绍
$menu_Culture='Culture';//众智文化
$menu_Events='Events';//众智大事记
$menu_TestingRoom='Testing Room';//众智实验室
$menu_Video='Video';//众智宣传片
$menu_News='News';//众智新闻
$menu_Honors='Honors';//众智荣誉
$menu_Logo='Trade Mark';//众智标识
$menu_Contact='Contact Us';//联系众智
$menu_Contact_B='CONTACT US';//联系众智
$menu_Join='Join Us';//加入众智
$menu_Join_B='JOIN US';//加入众智
$menu_Tool='Help';//帮助
$menu_FAQS='FAQS';//无需翻译
$menu_Onlineshop='Shop';//在线商城
$menu_Cloud='Cloud Monitoring Platform';//众智云平台
$menu_Cloud_teslayun='Teslayun Monitoring Platform';//众智特斯拉云平台

/*bottom*/
$bottom_Internet='SmartGen Internet +';//众智“互联网+”
$bottom_Cloud_Info='Control your genset at any time';//随时掌控您的发电机组
$bottom_WeChat='Chinese WeChat Service';//众智中文服务号
$bottom_WeChat_en='English WeChat Service';//众智英文服务号
$bottom_WeChat_Info='Scan QR code to get information in time';//扫一扫，及时了解众智资讯
$bottom_APP='SmartGen Products APP';//众智产品APP
$bottom_APP_Info='Get products information in real time';//实时了解众智产品最新资料
$bottom_Media='Smartgen Media';//众智自媒体
$bottom_Media_Info='Acquire trends of SmartGen at any time';//随时了解众智动态
$bottom_ProductInfo='Product Information';//产品资料
$bottom_ProductCata='Product Sample';//选型样本
$bottom_WEB='WEB';//旗下官网
$bottom_Alibaba='Alibaba';//阿里巴巴
$bottom_TEL='TEL';//电话
$bottom_FAX='FAX';//传真
$bottom_ADD='ADD';//地址
$bottom_ADDInfo='No.28 Jinsuo Road, Zhengzhou City, Henan Province, China';//中国·河南省郑州高新技术开发区金梭路28号
$bottom_EMAIL='E-MAIL';//邮箱
$bottom_ICP='豫ICP备11033962号-1';//无需翻译
$bottom_Slogan='HAND-IN-HAND WITH YOU, WIN-WIN IN FUTURE.';//与您携手，共赢未来。
$bottom_am='Online Customer Service';//在线客服
$bottom_hotline='';//技术服务热线

/*client*/
$client_title_a='be talking to ';//正在与
$client_title_b='';//对话中
$client_send='Send';//发送

/*message*/
$message_title='Please you leave contact information, we will contact you as soon as possible!';//请您留下联系方式，我们将尽快与您联系！
$message_name='Call';//称呼
$message_phone='Mobile Phone';//手机
$message_mail='E-mail';//邮箱
$message_question='Problem';//问题
$message_captcha='Verification code';//验证码
$message_submit='Submit';//提交
$message_case='Case-insensitive';//不区分大小写

/*index*/
$index_hint='In order to experience website better, we advise you use latest version of browsers like IE9, FireFox, Google Chrome, 360, QQ.';//为了让您更好的体验网站，建议您使用IE9及以上版本或火狐、Google Chrome、360、QQ等最新版本的浏览器!
$index_News='News';//众智新闻
$index_StarProduct='Star Products';//众智明星产品...
$index_More='More...';//更多...

/*search*/
$search_result='Search result';//搜索结果
$search_resultA='Search to ';//搜索到的
$search_resultB=' related information';//相关信息
$search_products='Search for products';//搜索到的产品
$search_solution='Search for solutions';//搜索到的解决方案
$search_case='Search for application case';//搜索到的应用案例
$search_news='Search for news';//搜索到的新闻

/*appdownload*/
$appdown_wechat='WeChat scan, clicking on the menu and select "open in a browser", open and then click the "Android download" to download the APP';//微信扫描后，点击右上角菜单，选择“在浏览器中打开”，打开后点击“立即下载”即可下载APP

/*productseries*/
$productseries_Jion='Join';//加入
$productseries_Comparison='Comparison';//开始比较

/*product*/
$product_Code='Product Code';//产品代码
$product_Power='Power Supply';//工作电源
$product_Case='Case Dimensions';//外形尺寸
$product_Panel='Panel Cutout';//开孔尺寸
$product_Temp='Operating Temp. ';//工作温度
$product_Weight='Weight';//重量
$product_Desc='Description';//产品描述
$product_Para='Parameter List';//产品参数表
$product_Typical='Typical Application';//典型应用图
$product_Model='3D Model Diagram';//三维模型图
$product_Download='Data Download';//资料下载
$product_Item='Function Item';//功能项
$product_Parameter='Parameter';//参数
$product_No_Parameter='No Parameters';//暂无参数
$product_DataTpye='Data Type';//资料类型
$product_Version='Version';//版本号
$product_DownloadLink='Download Link';//下载链接
$product_ViewOnline='View Online';//在线查看
$product_No_Download='No Download Information';//暂无下载资料
$product_Product_evaluation='Products accumulated comments';//产品累计评论
$product_Net_Friend='Enthusiastic net friends';//的热心网友
$product_eval_impress='Company impression';//公司印象
$product_eval_quality='Product quality';//产品质量
$product_eval_service='Service evaluation';//服务评价
$product_eval_product='Product evaluation';//产品评价
$product_eval_reproduct='Official reply';//官方回复
$product_eval_submit='Submit comments';//提交评论
$product_eval_wait='Loading verification code......';//正在加载验证码......
$product_eval_notice='Please drag the verification code to the corresponding position';//请先拖动验证码到相应位置
$product_eval_p_e='Phone or E-mail';//电话或邮箱
$product_Product_Application='Application Cases related to this product';//该产品相关应用案例
$product_Fistpage='First Page';//第一页
$product_Lastpage='Last Page';//最后一页

/*applicationcase*/
$product_NoApplication='No Application Cases';//暂无应用案例

/*scheme*/
$scheme_Solution='Solution';//解决方案
$scheme_Solutiondownload='Solution Download';//方案下载

/*datadownload*/
$download_Apptool='Application Tool';//应用工具
$download_cloudAPP='SmartGen cloud monitoring APP';//众智云监控APP
$download_cloudAPP_desc='SmartGen cloud platform APP immediately starts unit cloud monitoring';//众智云平台APP，立刻开启机组云监控，配套产品CMM366-3G/CMM366-ET/CMM363-2G
$download_AndroidAPP='Android download';//Android版下载
$download_productAPP_desc='Software is used for websites and sample selection, scanning QR code samples of the above products directly, can obtain the detailed information of the product';//软件为网站和选型样本配套使用，直接扫描样本上面的产品二维码，即可获得该产品的详细信息
$download_iGMPA6APP='iGMPA6';//Android版下载
$download_iGMPA6APP_desc='Intelligent unit monitoring platform mobile phone APP with SGB100 Bluetooth communication module to achieve unit control, parameter setting and other functions';//智能机组监控平台手机APP，配合SGB100蓝牙通信模块，实现机组的控制、参数设置等功能
$download_NET='.NET platform';//.NET平台
$download_NET_desc='HGM65XX/7XXX/9XXX series are used for test software. NET platform';//HGM65XX系列/7XXX系列/9XXX系列测试软件需使用.NET平台
$download_scheme='Series product parallel solutions';//系列产品并机方案清单
$download_scheme_cn='Chinese download';//中文下载
$download_scheme_en='English download';//英文下载
$download_Oldproducts='Expired Products';//下架产品
$download_Genset='Genset Control Modules';//发电机组控制模块
$download_ATScontrol='ATS Control Modules';//双电源控制模块
$download_Expansionmodules='Relay Expansion Modules';//继电器扩展模块
$download_Modules='Modules';//模块
$download_Name='Name';//名称
$download_Module='Model';//型号
$download_CN_Manual='Chinese Manual';//中文说明书
$download_EN_Manual='English Manual';//英文说明书
$download_Software='Software';//测试软件
$download_D='Download';//下载

/*catalogue*/
$catalogue_Year='Product Catalogue';//2016-2017年度
$catalogue_NoCatalogue='No Product Catalogue';//暂无选型样本

/*testingcenter*/
$testingcenter_title='SmartGen Testing Room';//众智实验室

/*news*/
$news_No='No News';//暂无新闻!

/*hr*/
$hr_job="Job Vacancy";//招聘职位
$hr_no_job="No job information!";//暂无招聘职位信息！

/*faqs*/
$faqs_abbr='FAQS';//常见问题解答
$faqs_full='Frequently Asked Questions(FAQS)';//常见问题解答(FAQS)
$faqs_QD='Question Description';//问题描述
$faqs_QA='Question Solving';//问题回答
$faqs_NOFAQ='No FAQs Information!';//暂无FAQs信息！
$faqs_search='results found for';//搜索到和
$faqs_nosearch='';//没有搜索到和
$faqs_searchcn='Related Information';//相关的问题

/*ecucode*/
$ecucode_full='ECU Fault Codes';//ECU故障代码
$ecucode_YY='Fault Cause';//故障原因
$ecucode_FY='Fault Reaction';//故障反应
$ecucode_CSH='Corrective Action';//纠正措施
$ecucode_NOFAQ='No ECU Fault Code Information!';//暂无ECU故障代码信息！
$ecucode_search='results found for';//搜索到和
$ecucode_nosearch='';//没有搜索到和
$ecucode_searchcn='Related Fault Codes';//相关的故障代码

/*wemedia*/
$wemedia_wechat='WeChat Public Platform';//众智微信公众平台
$wemedia_wechat_cn='Chinese WeChat Service Account';//扫描关注众智中文微信服务号
$wemedia_wechat_en='English WeChat Service Account';//扫描关注众智英文微信服务号
$wemedia_Microblog='Microblog';//众智微博平台
$wemedia_Microblog_sina='Sina';//点击关注众智新浪微博
$wemedia_Microblog_tencent='Tencent';//点击关注众智腾讯微博
$wemedia_Microblog_nets='Nets';//点击关注众智网易微博
$wemedia_Blog='Blog';//众智博客平台
$wemedia_Blog_hexun='Hexun';//点击查看众智和讯博客
$wemedia_Blog_nets='Nets';//点击查看众智网易博客
$wemedia_Blog_sohu='Sohu';//点击查看众智搜狐博客
$wemedia_Blog_sina='Sina';//点击查看众智新浪博客
$wemedia_Blog_tianya='Tianya';//点击查看众智天涯博客
$wemedia_Video='Video';//众智视频平台
$wemedia_Video_tencent='Tencent';//点击查看众智腾讯视频
$wemedia_Video_youku='Youku';//点击查看众智优酷视频
$wemedia_Video_tudou='Tudou';//点击查看众智土豆视频
$wemedia_library='Library';//众智文库合作机构
$wemedia_library_docin='Docin';//点击查看众智豆丁文库
$wemedia_SNS='SNS';
$wemedia_facebook='Facebook@SmartGen';
$wemedia_twitter='Twitter@SmartGen';
$wemedia_blog='Blog';
$wemedia_blog_blogger='Blogger@SmartGen';
$wemedia_blog_wordpress='Wordpress@SmartGen';
$wemedia_blog_tumblr='Tumblr@SmartGen';


/*productcomparison*/
$comparison_type='Type';//产品类型
$comparison_type_select='Please select a type';//请选择类型
$comparison_series_model='Series/Model';/*系列/型号*/
$comparison_series_select='Please select a series';//请选择系列
$comparison_model_select='Please select a model';//请选择型号

/*about*/
/*郑州众智科技股份有限公司简称众智、众智科技，成立于1998年，是新三板上市企业。专业从事发动机/发电机组智能控制、双电源切换开关及智能控制、发动机机体加热器、蓄电池充电器等相关产品的设计、研发、制造、销售和服务，是全球发电机组行业最具影响力的设备制造商之一。*/
$Profile_a='SMARTGEN(ZHENGZHOU) TECHNOLOGY CO., LTD. was established in 1998, a company which was listed on NEEQ. It specializes in desgin, development, manufacture, sale and service of engine / genset control, ATS and ATS control, engine heaters, battery chargers and related products. And it is one of the most influential equipment manufacturers in the genset industry around the world.';
/*历经20年的发展，我们共研发出几百种具有自主知识产权的控制模块，获得了近300项专利，以确保持续为全球客户提供最具价值的产品解决方案。*/
$Profile_b='After 20 years of development, SmartGen has successively developed hundreds of control modules with independent intellectual property rights and obtained almost 300 patents, to provide the most valuable product solutions for global customers.';
/*众智科技拥有中国多个第一，中国最早从事发电机组控制器、双电源切换控制器研发和生产的企业之一，中国唯一一家发电机组控制器通过德国MTU认证的公司，中国最早研发出一体化发电机组并联控制器......*/
$Profile_c='SmartGen has multiple firsts in China: it is one of the earliest enterprises in R&D and production of genset controller and ATS controller; it is the only enterprise whose genset controller through the German MTU certification; it is the earliest enterprise pioneered in the development and production of integrated genset parallel controller...';
/*众智科技在全球设立50多个办事处或代理机构，致力于向客户提供满意的产品和服务。我们将一如既往的不断创新与自我超越，争取成为全球发电机组行业最值得信赖的国际品牌！*/
$Profile_d='SmartGen, which owns more than 50 offices or agencies in domestic and overseas, is committed to providing satisfied products and services for customers. We will continue to innovate and self-transcend, strive to be the most trustworthy international brand!';

/*culture*/
/*企业精神*/
$culture_a='Enterprise Spirit';
/*自强不息，众智成城。*/
$culture_a_info='Self-improvement and unity make perfect.';
/*企业愿景*/
$culture_b='Enterprise Vision';
/*成长为行业最值得信赖的品牌，为世界上每一台设备都装备一颗更加智能的心！*/
$culture_b_info='Grow to be the most trusted brand in the industry and equip every piece of equipment of the world with a more intelligent brain.';
/*管理理念*/
$culture_c='Management Concept';
/*以人为本，科学高效。*/
$culture_c_info='People-oriented, scientific and efficient.';
/*经营理念*/
$culture_d='Business Idea';
/*持续地为合作伙伴创造价值，永不止步。*/
$culture_d_info='Create fortunes for partners sustainably and ceaselessly.';
/*质量方针*/
$culture_e='Quality Policy';
/*科技创新，品质一流，顾客至上，持续发展。*/
$culture_e_info='Technological innovation, best quality, customer first and sustainable development.';
/*合作理念*/
$culture_f='Cooperation Concept';
/*与您携手、共赢未来。*/
$culture_f_info='Hand-in-hand with you, win-win in future.';

/*history*/
/*公司成立于河南省郑州市中原区伏牛路，营业面积30m²，一切从零做起；*/
$history_a='Company was founded in Zhongyuan Zone, Zhengzhou, Henan with 30m² ares and started from scratch on March 18, 1998.';
/*第一台GAM系列发电机组控制器研发成功；*/
$history_b='First GAM series genset controller was developed in 1998.';
/*更名为郑州众智电子设备有限公司*/
$history_c='Company renamed as Zhengzhou Zhongzhi Electronic Equipment Ltd. In 2003.';
/*第一台HGM系列发电机组自动化控制器研发成功；*/
$history_d='First HGM series genset automation controller was developed in 2004.';
/*公司搬迁至河南省郑州高新区银屏路12号（创业中心5号园），营业面积800m²，年营业额1263万元；*/
$history_e='Company moved to No.12 Yinping Road in Hi-tech zone, Zhengzhou with 800m² business area and annual sales volume reached  12.63 million yuan in 2006.';
/*通过了英国摩迪公司ISO9001国际标准化质量管理体系认证；*/
$history_f='Company passed the evaluation of ISO9001 Quality Management System in Oct., 2006.';
/*营业面积扩展到到2000m²；*/
$history_g='Business area was extended to 2000m².';
/*公司搬迁至河南省郑州高新区金梭路28号，占地面积10000m²，营业面积5000m²；*/
$history_h='Company removed to No.2, Jinsuo Road, Hi-tech zone in Zhengzhou with area 10000m²(business area:5000m² ) in 2009.';
/*建立了EMC实验室，机组实验室，环境试验室；*/
$history_i='Company built EMC Lab, Genset Lab and Environmental Lab in March, 2010. ';
/*公司进行股份制改造成功，进入郑州高新区新三板上市后备企业，更名为郑州众智科技股份有限公司；*/
$history_j='Company shareholding system reform achieved success and enter back-up enterprises who was about to be listed on NEEQ,  renaming as Zhengzhou Smartgen Technology Co., Ltd. in Dec. 2010.';
/*被评为郑州市安全生产单位；*/
$history_k='Company was rated as unit with safety in production in Zhengzhou in Jan. 2011.';
/*研发中心被认定为市级研发中心；*/
$history_l='R & D center was evaluated as city class in May, 2011.';
/*荣获郑州市第二批创新型企业称号；*/
$history_m='Company had the honor to get 2rd batch of Innovative Enterprise of Zhengzhou in Jun., 2011.';
/*被认定为河南省高新技术企业；*/
$history_n='Company was entitled as Hennan Hi-tech Enterprise.';
/*通过了德国奔驰“MTU”的中国区独家认证。*/
$history_o='Passed the “MTU” certificate in Nov., 2011.';
/*全新推出发电机组远程测控智能型控制系统；*/
$history_p='Genset Remote Control System was launched in Jun., 2012.';
/*公司主办发电机组行业高端论坛在郑州成功举行；*/
$history_q='Genset Forum held by Zhongzhi got a great success in Sept., 2012.';
/*圆满承办了全国移动电站标准化技术委员会国家标准起草小组工作会议，参与了《天然气发电机通用技术标准》的起草和制订；*/
$history_r='Company hosted National Mobile Power Station Technical Committee for Standardization meeting with standards group and  attended the drafting and making of NG Genset Common Technical Standards in Otc., 2012.';
/*“smartgen”荣获河南省著名商标；*/
$history_s='The “smartgen” was awarded the famous brand in Henan province.';
/*郑州众智科技股份有限公司党支部成立。*/
$history_t='Zhengzhou Smartgen Technology Co., Ltd. Party Branch was established in Dec., 2012.';
/*智能型发电机组控制器的研究通过科技成果鉴定；*/
$history_u='The research of automation genset controllers passed Science and Technology Achievement appraisal in Dec., 2012.';
/*船机产品通过中国船级社“CCS”认证，是国内唯一可替代高端进口产品的船用控制系统；*/
$history_v='SmartGen products passed CCS certificate in May, 2013 and became the only marine system which can replace high-end imports.';
/*众智研发的基于物联网基础的智能发电机组控制系统入选“2013国家火炬计划；*/
$history_w='Intelligent genset control system based on Internet of Thins by SmartGen was listed ‘National Torch Program 2013’ in Sept., 2013.';
/*公司扩建新厂房建成，营业面积将增加到9000m²。*/
$history_x='New plant extension achieved and business area increased to 9000m² in Jan., 2014.';
/*公司“新三板”挂牌，股票代码：430504*/
$history_y='SmartGen was listed on NEEQ in Jan., 2014.';
/*公司通过了天祥（原英国摩迪）公司OHSAS18001职业健康安全管理体系的认证。*/
$history_z='SmartGen passed the evaluation of OHSAS18001 Occupational Safety and Health Management system in Oct., 2014.';
/*公司通过了天祥（原英国摩迪）公司ISO14001环境管理体系的认证。*/
$history_aa='SmartGen passed the evaluation of ISO14001 Environmental Management System in Oct., 2014.';
/*公司通过了郑州高新区首家4A级标准化良好行为企业验收。*/
$history_ab='SmartGen firstly passed Zhengzhou Hi-tech Zone acceptance check on ‘AAAA-Class’ Enterprise with Good Practice on  Standardization in Dec., 2014';
/*2015年年度营业收入过亿元。*/
$history_ac='The business income in 2015 was more than RMB100 million.';
/*通过移动电站控制工程技术研究中心认证。*/
$history_ad='SmartGen earned certificate of Mobile Power Station Control Engineering Research Center';
/*推出云监控模块+众智云平台：*/
$history_ae='Launch cloud monitoring modems+ SmartGen cloud platform ';
/*组织协办“2016年内燃发电设备行业工作会议”*/
$history_af='SmartGen co-organized 2016 Internal Combustion Generation Equipment Industry Session';
/*组织举办“内燃发电控制技术峰会”*/
$history_ag='SmartGen held Internal Combustion Engine Genset Control Tech Conference';

/*honor*/
$honor_a='CE Certificate';//众智产品CE认证证书
$honor_b='Patent Certificates';//众智产品专利证书
$honor_c='CCS-Pressure Transducer';//船级社认证-压力变送器
$honor_d='CCS-Parallel and Protection Controller';//船级社认证-并联保护控制器
$honor_e='CCS-Temperature Sensors';//船级社认证-温度传感器
$honor_f='CCS-Control Boxes(Panels)';//船级社认证-控制箱
$honor_g='ISO9001';//众智ISO9001认证中文证书
$honor_h='ISO9001';//众智ISO9001认证英文证书
$honor_i='ISO14001';//众智ISO14001环境管理体系中文证书
$honor_j='ISO14001';//众智ISO14001环境管理体系英文证书
$honor_k='OHSAS18001';//众智OHSAS18001职业健康安全管理体系中文证书
$honor_l='OHSAS18001';//众智OHSAS18001职业健康安全管理体系英文证书
$honor_m='Software Copyright';//计算机软件著作权登记证书
$honor_n='Henan Famous-brand Products Certificate';//河南省名牌产品证书
$honor_o='AAAA Class Good Standardizing Practice Certificate';//标准化良好行为证书
$honor_p='High-tech Enterprise Certificate';//众智高新企业认证证书
$honor_q='Enterprise Technology Center';//市级企业技术中心
$honor_r='Small and Medium-sized technology-based Enterprise Certificate';//科技型中小企业证书
$honor_s='CEEIA Member Certificate';//中国电器工业协会会员证书
$honor_t='France BV Certification';//法国船级社认证

/*testingcenter*/
/*众智试验室筹建于2010年，占地面积近千平方米。历时多年的逐渐完善，目前已经成为了行业内屈指可数的一流试验基地。*/
$testingcenter_a='SmartGen Testing Room was established in 2010, covering an area of nearly 1,000 square metres. With gradual improvements for years, it has become one of the handful of top-ranking testing bases in the industry.';
/*众智试验室先后从国内外知名企业采购多套高精尖的测试设备，以确保各种产品符合最高品质标准。*/
$testingcenter_b='In order to meet the highest quality standard of various products, SmartGen Testing Room successively purchased sets of advanced test equipment from domestic and foreign well-known enterprises.';
/*目前主要测试类型包括：EMC电磁兼容性测试、环境类测试、功能类测试。*/
$testingcenter_c='At present, the main test types include EMC tests, environmental tests and prototype tests.';
/*电磁兼容试验设备主要包括：射频场抗干扰度测试系统、汽车干扰模拟发生器、静电放电发生器、衰减震荡波发生器、雷击浪涌发生器、脉冲群发生器、智能工频磁场发生器、一体化传导敏感度测试仪、泄漏电流测试仪等。*/
$testingcenter_d='EMC test equipment mainly includes RF Fields Immunity Test System, Motorcar Interference Analog Generator, ESD Generator, Damping Oscillation Wave Generator, Thunderstrike and Surge Generator, Pulse Group Generator, intelligent Power Frequency Magnetic Fields Generator, Integrated Conducted Susceptibility Tester, Leakage Current Tester, etc.';
/*环境类测试设备主要包括：电动振动测试台、单臂跌落试验设备、落求冲击测试设备、高低温交变湿热试验箱、防水淋雨试验箱、冲击碰撞测试台、燃烧测试仪、盐雾测试设备等。*/
$testingcenter_e='Environmental test equipment mainly includes Electric Vibration Test Table, Impact Test Table, Falling-ball Impact Test Equipment, Salt Spray Test Equipment, Temperature and Humidity Test Chamber, Xenon Lamp Aging Chamber, Sand and Dust Test Chamber, Rain Test Chamber, Combustion Tester, Single Arm Drop Test Equipment, etc.';
/*功能类测试主要包括：多机并联发电测试系统、光油互补发电测试系统、燃气发电测试系统、汽油发电测试系统、加热器测试系统等。*/
$testingcenter_f='Functional tests include Multi-units parallel Generation Test System, Solar-diesel Hybrid Generation Test system, Gas Generation Test System, Gasoline Generation Test System, Heaters Test System, etc.';

/*trademark*/
$trademark_a='SmartGen Logo Meaning';//众智标识诠释
$trademark_b='Three “triangles” form the word - ”众” based on golden ratio, which manifests SmartGeners stand united and enterprise spirit of ”Unity is strength”.';//三个“三角形”各个点与点，点与面之间都严格遵守黄金比例，叠加为一个众字，体现了众智科技团结一心，众智成城的企业精神。
$trademark_c='The pyramid consisted of three “triangles” symbolizes SmartGen possesses a solid foundation and stable development.';//三个“三角形”组成的金字塔，寓意众智科技基业稳固，平稳发展。
$trademark_d='Diamond in three “triangles” indicates SmartGen’s meticulosity and striving for perfection on products quality.';//三个“三角形”各个部分按照黄金比例首尾相连，中间似一颗闪亮的钻石。表达了众智科技对产品品质一丝不苟、精益求精的专业态度。
$trademark_e='Three “triangles”, just like a fighter, present enterprise owns a clear goal and grows rapidly.';//三个“三角形”犹如一架现代化战斗机，代表企业目标明确、发展快速。
$trademark_f='Sapphire, as standard color of trademark, is the symbol of sagacity, rigorousness, technology as well as striving for excellence to work!';//企业标志以宝石蓝为标准色，蓝色代表睿智、严谨、科技、以及对待工作精益求精的态度。
$trademark_g='The meaning of SmartGen';//SmartGen标识含义
$trademark_h='SmartGen is our English trademark';//SmartGen是众智的英文注册商标。
$trademark_i='"Smart" means ingenious, intelligent and clever.';//Smart是灵巧的、智能的、聪明的。
$trademark_j='"Gen" is the abbreviation of gen-set.';//Gen是generator的缩写，发电机组的意思。
$trademark_k='SmartGen implies making gen-set more intelligent and humanized to serve humans better!';//SmartGen的寓意也就是让发电机组变的更加智能、更加人性化、更好的为人类服务！
$trademark_l='SmartGen Logos Download';//众智Logo下载
$trademark_m='Chinses logo';//中文LOGO
$trademark_n='Chinese logo (vertical) ';//中文LOGO竖版
$trademark_o='English logo';//英文LOGO
$trademark_p='English logo & Slogan';//英文LOGO和标语
$trademark_q='Whole logo';//中文与英文标识

/*contact*/
$contact_company='SMARTGEN(ZHENGZHOU) TECHNOLOGY CO., LTD.';//郑州众智科技股份有限公司
$contact_hotline='Free Services Hotline';//全国免费服务热线
$contact_postcode='Postcode';//邮编
$contact_QQ='QQ Technical Communication group';//QQ技术交流群
$contact_navigation='Navigation: No.28 Jinsuo Road, Zhengzhou City, Henan Province, China';//导航地址：河南省郑州市高新区(或中原区)金梭路与冬青街交叉口向南50米路西（金梭路28号）
$contact_cnoffice="SmartGen's Offices in China";//众智中国办事处
$contact_ningde='Ningde Office';//宁德办事处
$contact_ningde_m='Manager Zhang';//张经理
$contact_fuzhou='Fuzhou Office';//福州办事处
$contact_fuzhou_m='Manager Jiang';//姜经理
$contact_shanghai='Shanghai Office';//上海办事处
$contact_shanghai_m='Manager Li';//李经理
$contact_chengdu='Chengdu Office';//成都办事处
$contact_chengdu_m='Manager Wang';//王经理
$contact_yangzhou='Yangzhou Office';//扬州办事处
$contact_yangzhou_m='Manager Zhang';//张经理
$contact_shandong='Shandong Office';//山东办事处
$contact_shandong_m='Manager Chen';//陈经理
$contact_beijing='Beijing Office';//北京办事处
$contact_beijing_m='Manager Liu';//刘经理
$contact_guangzhou='Guangzhou Office';//广州办事处
$contact_guangzhou_m='Manager Liu';//刘经理
$contact_shenzhen='Shenzhen Office';//深圳办事处
$contact_shenzhen_m='Manager Zhang';//张经理
$contact_changzhou='Changzhou Office';//常州办事处
$contact_changzhou_m='Manager Yang';//杨经理
$contact_qingdao='Qingdao Office';//青岛办事处
$contact_qingdao_m='Manager Cui';//崔经理
$contact_phone='MOBIL';//手机
$contact_enoffice='SmartGen Overseas Sales Dept.';//众智海外销售部
$contact_mxu='Ada Xu';//徐经理
$contact_myun='Icy Yun';//恽经理
$contact_mzhu='Sara Zhu';//朱经理
$contact_mwang='Kyrie Wang';//王经理
$contact_turkeyoffice="SmartGen’s Agent in Turkey";//众智土耳其代理商
$contact_ATTN='ATTN';//联系人
$contact_overseaoffice="SmartGen Overseas Sales Dept. 1st";//众智海外销售一部
$contact_overseaarea="SALES AREA：South America, Vietnam, Thailand, Myanmar, Laos, Cambodia, Bangladesh";//销售区域：南美洲、越南、泰国、缅甸、老挝、柬埔寨、孟加拉
$contact_MiddleEast ='SmartGen Middle East Sales & Service Center';//众智中东销售服务中心
$contact_Taiwan ="SmartGen’s Agent in Taiwan";//众智台湾代理商
$contact_Taiwan_coma='YEHSHIN Electric Co., Ltd.';//曄鑫電機有限公司
$contact_Taiwan_attn='Jiancai Chen';//陳建財
$contact_Taiwan_add='NO. 18-29, LANE 868, SECTION 2, GUANGMING ROAD, DALIAO District, Kaohsiung CITY, TAIWAN.';//台灣高雄市大寮區光明路二段868巷18之29號
$contact_Taiwan_comb="FINE AND GOOD TRADING CO., LTD.";//好善有限公司 
$contact_southafrica="SmartGen’s Agent in South Africa";//众智南非代理商
$contact_jakarta="SmartGen’s Agent in Jakarta";//众智雅加达代理商
$contact_malaysia="SmartGen’s Agent in Malaysia";//众智马来西亚代理商
$contact_israel="SmartGen's Agent in Israel";//众智以色列代理商
$contact_vietnam="SmartGen's Agent in Vietnam";//众智越南代理商
$contact_australia="SmartGen's Agent in Australia";//众智澳大利亚代理商
$contact_MAIL="MAIL";//邮件地址
$contact_spain="SmartGen's Agent in Spain";//众智西班牙代理商
$contact_Puerto="SmartGen's Agent in Puerto Rico";//众智波多黎各代理商
$contact_Maldives="SmartGen's Agent in Republic of Maldives";//众智马尔代夫共和国代理商
$contact_Korea="SmartGen's Agent in Korea";//众智韩国代理商
$contact_Medan="SmartGen's Agent in Medan";//众智棉兰代理商
$contact_Ireland="SmartGen's Agent in Ireland";//众智爱尔兰代理商
$contact_Holland="SmartGen's Agent in Holland (Europe after-sales office)";//众智荷兰代理商
$contact_salearea="SALES AREA";//销售区域
$contact_Singapore="SmartGen's Agent in Singapore";//众智新加坡代理商
$contact_Singapore_HGM="HGM Series Products Agent";//HGM系列产品代理商
$contact_Singapore_HAT="HAT Series Products Agent";//HAT系列产品代理商
$contact_Thailand="SmartGen’s Agent in Thailand";//众智泰国代理商
?>