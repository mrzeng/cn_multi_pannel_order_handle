<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-1.9.0.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/jquery/jquery-migrate-1.1.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/menu.js";?>"></script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="menu">
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu"></ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<div class="headbar">
	<div class="position">订单<span>></span><span>订单管理</span><span>></span><span>订单回收站</span></div>
	<div class="operating">
		<a href="javascript:;"><button class="operating_btn" type="button" onclick="window.location='<?php echo IUrl::creatUrl("/order/order_list");?>'"><span class="import">返回列表</span></button></a>
		<a href="javascript:void(0)" onclick="selectAll('id[]')"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0)" onclick="recycle_del()"><button class="operating_btn" type="button"><span class="delete">彻底删除</span></button></a>
		<a href="javascript:void(0)" onclick="recycle_restore()"><button class="operating_btn"><span class="recover">还原</span></button></a>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="30px" />
			<col width="155px" />
			<col width="75px" />
			<col width="75px" />
			<col width="75px" />
			<col width="75px" />
			<col />
			<thead>
				<tr>
					<th class="t_c">选择</th>
					<th>订单号</th>
					<th>收货人</th>
					<th>支付状态</th>
					<th>发货状态</th>
					<th>配送方式</th>
					<th>支付方式</th>
					<th>用户名</th>
					<th>下单时间</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<form name="orderForm" action="" method="post">
<div class="content">
	<table class="list_table">
		<col width="30px" />
		<col width="155px" />
		<col width="75px" />
		<col width="75px" />
		<col width="75px" />
		<col width="75px" />
		<col />
		<tbody>
			<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
			<?php $query = new IQuery("order as o");$query->join = "left join delivery as d on o.distribution = d.id left join payment as p on o.pay_type = p.id left join user as u on u.id = o.user_id";$query->fields = "o.id as oid,d.name as dname,p.name as pname,o.order_no,o.accept_name,o.pay_status,o.distribution_status,u.username,o.create_time,o.status";$query->where = "if_del = 1";$query->page = "$page";$items = $query->find(); foreach($items as $key => $item){?>
			<tr>
				<td class="t_c"><input name="id[]" type="checkbox" value="<?php echo isset($item['oid'])?$item['oid']:"";?>" /></td>
				<td><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
				<td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				<td><?php if($item['pay_status']==0){?>未付款<?php }else{?>已付款<?php }?></td>
				<td><?php if($item['distribution_status']==0){?>未发货<?php }else{?>已发货<?php }?></td>
				<td><?php echo isset($item['dname'])?$item['dname']:"";?></td>
				<td><?php echo isset($item['pname'])?$item['pname']:"";?></td>
				<td><?php echo $item['username']=='' ? '游客' : $item['username'];?></td>
				<td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
				<td>
					<?php if($item['status']<3){?>
					<a href="<?php echo IUrl::creatUrl("/order/order_edit/id/$item[oid]");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" title="编辑"/></a>
					<?php }?>
					<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/order/order_recycle_del/id/$item[oid]");?>'})"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" /></a>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php echo $query->getPageBar();?>
</form>

<script type="text/javascript">
	function recycle_restore()
	{
		$("form[name='orderForm']").attr('action','<?php echo IUrl::creatUrl("/order/order_recycle_restore");?>');
		confirm('确定要还原所选中的信息吗？','formSubmit(\'orderForm\')');
	}
	function recycle_del()
	{
		$("form[name='orderForm']").attr('action','<?php echo IUrl::creatUrl("/order/order_recycle_del");?>');
		confirm('确定要彻底删除所选中的信息吗？','formSubmit(\'orderForm\')');
	}
</script>

		</div>
		<div id="separator"></div>
	</div>

	<script type='text/javascript'>
		//DOM加载完毕执行
		$(function(){
			//隔行换色
			$(".list_table tr:nth-child(even)").addClass('even');
			$(".list_table tr").hover(
				function () {
					$(this).addClass("sel");
				},
				function () {
					$(this).removeClass("sel");
				}
			);

			//后台菜单创建
			<?php $menu = new Menu();?>
			var data = <?php echo $menu->submenu();?>;
			var current = '<?php echo $menu->current;?>';
			var url='<?php echo IUrl::creatUrl("/");?>';
			initMenu(data,current,url);
		});
	</script>
</body>
</html>
