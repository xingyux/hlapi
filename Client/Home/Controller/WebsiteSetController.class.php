<?php
/**
 *
 * @team SlipperClown (http://www.slippersclown.com/)
 * @developer Hacker丶Wand (578112964@qq.com)
 * @date    2017-06-05 17:44:27
 * @version $Id$
 */
namespace Home\Controller;

use Think\Controller;
use \Common\Util\WebsiteSetConfig;

class WebsiteSetController extends LoginController
{

    public function index()
    {
        $config = WebsiteSetConfig::all();
        $this->assign('list', $config['list']);
        $tmpletelist = array();
        $get_Theme = get_Theme();
        $dp = dir(MODULE_PATH . "View/");

        while ($file = $dp->read()) {
            if ($file != '.' && $file != '..' && is_dir(MODULE_PATH . "View/{$file}/")) {
                $xml = MODULE_PATH . "View/{$file}/info.xml";
                $info = array();
                if (file_exists($xml)) {
                    $info = simplexml_load_file($xml, 'SimpleXMLElement', LIBXML_NOCDATA);


                    $info = json_decode(json_encode( $info ),true);

              
                } else {
                    $info["name"] = $file;
                    $info["author"] = "未知";
                    $info["lastdate"] = "未知";
                }
                $tmpletelist[] = array("path" => $file, "info" => $info);

            }
        }
        $dp->close();
        $this->assign('Theme', $get_Theme);
        $this->assign('ThemeList', $tmpletelist);
        $this->display();
    }

    public function setTheme()
    {
        $theme = I("post.theme");
        if (file_put_contents(CONF_PATH . "/tmplete_config.php", '<?php
		return array(
		\'tmplete_path\'=>\'' . $theme . '\'
		);
		?>')) {
            $this->success('保存成功');
        } else {
            $this->error('修改失败，请修改' . CONF_PATH . 'tmplete_config.php文件权限');
        }
    }

    public function setStatic()
    {
        if (!IS_POST)
            exit;
        WebsiteSetConfig::setStatic();
        return $this->success('保存成功');
    }

    public function del()
    {
        WebsiteSetConfig::del();
        return $this->success('删除成功');
    }

    public function setList()
    {
        if (!IS_POST)
            exit;
        WebsiteSetConfig::setList();
        return $this->success('保存成功');
    }

    public function addList()
    {

        if (!IS_POST)
            exit;
        WebsiteSetConfig::addList();
        return $this->success('添加成功');

    }

    public function addGroup()
    {
        if (!IS_POST)
            exit;
        WebsiteSetConfig::addGroup();
        return $this->success('添加成功');
    }

    public function delGroup()
    {
        WebsiteSetConfig::delGroup();
        return $this->success('删除成功');
    }

    public function upload_logo()
    {
        $get_Theme = get_Theme();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('png');// 设置附件上传类型
        $upload->rootPath = BASE_PATH . '/Public/' . $get_Theme . '/web/images/'; // 设置附件上传根目录
        $upload->saveName = 'logo';
        $upload->savePath = '';
        $upload->autoSub = false;

        unlink(BASE_PATH . '/Public/' . $get_Theme . '/web/images/logo.png');
        // 上传文件
        $info = $upload->uploadOne($_FILES['image']);
        if ($info) {
            echo json_encode(array('code' => 1));
        } else {
            echo json_encode(array('code' => 0, 'msg' => $upload->getError()));
        }
    }

    public function upload_qr()
    {
        $get_Theme = get_Theme();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728;// 设置附件上传大小
        $upload->exts = array('png');// 设置附件上传类型
        $upload->rootPath = BASE_PATH . '/Public/' . $get_Theme . '/web/images/'; // 设置附件上传根目录
        $upload->saveName = 'qrcode';
        $upload->savePath = '';
        $upload->autoSub = false;

        unlink(BASE_PATH . '/Public/' . $get_Theme . '/web/images/qrcode.png');
        // 上传文件
        $info = $upload->uploadOne($_FILES['image']);
        if ($info) {
            echo json_encode(array('code' => 1));
        } else {
            echo json_encode(array('code' => 0, 'msg' => $upload->getError()));
        }
    }

}