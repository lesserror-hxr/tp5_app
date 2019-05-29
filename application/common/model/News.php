<?php
namespace app\common\model;


class News extends Base
{
    /**
     * 后台自动化分页
     * @param array $data
     */
    public function getNews($data = [])
    {
        $data['status'] = [
            'neq',config('code.status_delete')
        ];

        $order = ['id' => 'desc'];

        $result = $this->where($data)
            ->order($order)
            ->paginate();

        return $result;
    }

    /**
     * 根据条件获取数据
     * @param array $param
     */
    public function getNewsByCondition($param = [],$from = 0,$size = 5)
    {
        // 判断是否传递了 文章状态参数
        if(!isset($param['status'])){
            $param['status'] = [
                'neq',config('code.status_delete')
            ];
        }


        $order = ['id' => 'desc'];

        $result = $this->where($param)
            ->field($this->_getListField())
            ->limit($from,$size)
            ->order($order)
            ->select();

        return $result;
    }

    /**
     * 根据条件来获取列表的数据的总数
     * @param array $param
     */
    public function getNewsCountByCondition($param = [])
    {

        // 判断是否传递了 文章状态参数
        if(!isset($param['status'])){
            $data['status'] = [
                'neq',config('code.status_delete')
            ];
        }


        $count = $this->where($param)
            ->count();

        return $count;
    }

    /*
     * 获取首页头图数据
     * @param int $num
     * @return array
     */
    public function getIndexHeadNormalNews($num = 4)
    {
        $data = [
            'status' => 1,
            'is_head_figure' => 1
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /**
     * 获取推荐内容
     * @param int $num
     */
    public function getRankNormalNews($num = 5)
    {
        $data = [
            'status'      => 1,
        ];

        $order = [
            'read_count' => 'desc',
        ];

        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /*
     * 获取推荐的数据
     */
    public function getPositionNormalNews($num = 20)
    {
        $data = [
            'status' => 1,
            'is_position' => 1
        ];

        $order = [
            'id' => 'desc',
        ];

        return $this->where($data)
            ->field($this->_getListField())
            ->order($order)
            ->limit($num)
            ->select();
    }

    /**
     * 通用化获取参数的数据字段
     * @return array
     */
    private function _getListField()
    {
        return ['id','catid','image','title','read_count','status','is_position','update_time','create_time'];
    }
}
