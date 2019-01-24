CREATE TABLE `bp_dm_assess` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_num` varchar(20) DEFAULT NULL COMMENT '学号',
  `name` varchar(20) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(1) DEFAULT NULL COMMENT '1:男 2:女',
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL DEFAULT '0' COMMENT '楼栋',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `grade_id` varchar(10) DEFAULT NULL COMMENT '年级ID',
  `class_id` varchar(10) DEFAULT NULL COMMENT '班级ID',
  `info` varchar(500) DEFAULT NULL COMMENT '内容',
  `remark` varchar(500) DEFAULT NULL COMMENT '备注',
  `happen_date` int(10) NOT NULL DEFAULT '0' COMMENT '发生日期',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:表扬 2:违规',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `grade_id` (`grade_id`),
  KEY `class_id` (`class_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='学生评定表';



CREATE TABLE `bp_dm_build` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) NOT NULL COMMENT '校区ID',
  `build_name` varchar(10) NOT NULL COMMENT '楼栋名称',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_name` (`build_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='楼栋表';


CREATE TABLE `bp_dm_build_manage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) DEFAULT NULL COMMENT '楼栋ID',
  `job_num` varchar(20) DEFAULT NULL COMMENT '工号',
  `name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `idcard` varchar(30) DEFAULT NULL COMMENT '身份证',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='楼栋管理员';


CREATE TABLE `bp_dm_dormitory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) NOT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL COMMENT '楼栋ID',
  `floor_id` int(10) NOT NULL COMMENT '楼层ID',
  `room_num` varchar(10) DEFAULT NULL COMMENT '房间号',
  `several` int(10) DEFAULT NULL COMMENT '几人间',
  `television` int(10) DEFAULT '0' COMMENT '电视',
  `washer` int(10) DEFAULT '0' COMMENT '洗衣机',
  `stool` int(10) DEFAULT '0' COMMENT '凳子',
  `desk` int(10) DEFAULT '0' COMMENT '桌子',
  `bed` int(10) DEFAULT '0' COMMENT '床铺',
  `wardrobe` int(10) DEFAULT '0' COMMENT '衣柜',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `room_num` (`room_num`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='宿舍表';


CREATE TABLE `bp_dm_dormitory_hygiene` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL DEFAULT '0' COMMENT '楼栋',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `gd_id` int(10) DEFAULT NULL COMMENT '年级',
  `cl_id` int(10) DEFAULT NULL COMMENT '班级',
  `score` varchar(10) DEFAULT NULL COMMENT '得分',
  `image` varchar(500) DEFAULT NULL COMMENT '图片',
  `remark` varchar(500) NOT NULL DEFAULT '0' COMMENT '备注',
  `exam_date` int(10) NOT NULL DEFAULT '0' COMMENT '检查日期',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `dormitory_id` (`dormitory_id`),
  KEY `gd_id` (`gd_id`),
  KEY `cl_id` (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='卫生量化考核表';


CREATE TABLE `bp_dm_dormitory_manage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) DEFAULT NULL COMMENT '楼栋ID',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `job_num` varchar(20) DEFAULT NULL COMMENT '工号',
  `name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `dormitory_id` (`dormitory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='宿舍管理员';


CREATE TABLE `bp_dm_employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_num` varchar(10) DEFAULT NULL COMMENT '工号',
  `name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(1) DEFAULT NULL COMMENT '1:男 2:女',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `idcard` varchar(20) DEFAULT NULL COMMENT '身份证',
  `address` varchar(50) DEFAULT NULL COMMENT '联系地址',
  `department` varchar(10) DEFAULT NULL COMMENT '聘用部门',
  `profession` varchar(10) DEFAULT NULL COMMENT '工种',
  `into_date` int(10) DEFAULT NULL COMMENT '任职日期',
  `out_date` int(10) DEFAULT NULL COMMENT '离职日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='员工管理';


CREATE TABLE `bp_dm_floor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) NOT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL COMMENT '楼栋ID',
  `floor_name` varchar(10) NOT NULL COMMENT '楼层名称',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_name` (`floor_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='楼层表';


CREATE TABLE `bp_dm_hitch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '申报人',
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL DEFAULT '0',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:人为 2:自然',
  `info` varchar(500) DEFAULT NULL COMMENT '故障内容',
  `construction` varchar(10) DEFAULT NULL COMMENT '施工员',
  `charge` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收费金额',
  `phone` varchar(20) DEFAULT NULL COMMENT '施工员电话',
  `register_date` int(10) DEFAULT NULL COMMENT '登记日期',
  `handle_date` int(10) DEFAULT NULL COMMENT '处理日期',
  `status` tinyint(1) DEFAULT '0' COMMENT '0:未处理 1:已处理',
  `toll_collector` varchar(10) NOT NULL DEFAULT '' COMMENT '收费员',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `dormitory_id` (`dormitory_id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='物品损坏维修记录';


CREATE TABLE `bp_dm_honorable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_num` varchar(20) DEFAULT NULL COMMENT '学号',
  `name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL DEFAULT '0' COMMENT '楼栋',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `goods_name` varchar(50) DEFAULT NULL COMMENT '物品名称',
  `moveout_date` int(10) DEFAULT NULL COMMENT '搬出时间',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `dormitory_id` (`dormitory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='贵重物品搬出登记';


DROP TABLE IF EXISTS `bp_dm_stay`;
CREATE TABLE `bp_dm_stay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_uid` int(10) DEFAULT NULL COMMENT '学生ID(admin表权限为学生的数据)',
  `student_num` varchar(10) NOT NULL COMMENT '学号',
  `name` varchar(6) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(1) DEFAULT NULL COMMENT '1:男 2:女',
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) DEFAULT NULL COMMENT '楼栋ID',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `before_campus_id` int(10) DEFAULT NULL COMMENT '原校区ID',
  `before_build_id` int(10) DEFAULT NULL COMMENT '原楼栋ID',
  `before_floor_id` int(10) DEFAULT NULL COMMENT '原楼层ID',
  `before_dormitory_id` int(11) DEFAULT NULL COMMENT '原宿舍ID',
  `grade_id` int(10) DEFAULT NULL COMMENT '年级',
  `class_id` int(10) DEFAULT NULL COMMENT '班级',
  `phone` varchar(15) DEFAULT NULL COMMENT '电话',
  `idcard` varchar(30) DEFAULT NULL COMMENT '身份证',
  `record_date` int(10) DEFAULT NULL COMMENT '登记日期',
  `adjust_date` int(10) DEFAULT NULL COMMENT '调房时间',
  PRIMARY KEY (`id`),
  KEY `ad_uid` (`ad_uid`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `dormitory_id` (`dormitory_id`),
  KEY `grade_id` (`grade_id`),
  KEY `class_id` (`class_id`),
  KEY `student_num` (`student_num`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='学生入住信息表';


CREATE TABLE `bp_dm_visit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `sex` tinyint(1) DEFAULT NULL COMMENT '1:男 2:女',
  `idcard` varchar(30) DEFAULT NULL COMMENT '身份证',
  `campus_id` int(10) DEFAULT NULL COMMENT '校区ID',
  `build_id` int(10) NOT NULL DEFAULT '0',
  `floor_id` int(10) DEFAULT NULL COMMENT '楼层ID',
  `dormitory_id` int(10) DEFAULT NULL COMMENT '宿舍ID',
  `teacher_identity` varchar(10) DEFAULT NULL COMMENT '教师身份',
  `interviewed` varchar(10) DEFAULT NULL COMMENT '被访人姓名',
  `interviewed_relation` varchar(10) DEFAULT NULL COMMENT '与被访人关系',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:老师访问 2:外来人员',
  `into_date` int(10) DEFAULT NULL COMMENT '进入时间',
  `out_date` int(10) DEFAULT NULL COMMENT '离开时间',
  PRIMARY KEY (`id`),
  KEY `campus_id` (`campus_id`),
  KEY `bulid_id` (`build_id`),
  KEY `floor_id` (`floor_id`),
  KEY `dormitory_id` (`dormitory_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='外来人员访问表';


ALTER TABLE `bp_sxd_student_info` ADD COLUMN is_quarter TINYINT(1) DEFAULT 0 COMMENT '是否已分配住宿';