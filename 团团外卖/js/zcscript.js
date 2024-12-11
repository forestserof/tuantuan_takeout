// 获取身份选择框
const roleSelect = document.getElementById('role');
// 获取用户名输入框
const usernameInput = document.getElementById('username');
// 获取地址输入框及其外层元素
const addressGroup = document.getElementById('address-group');
const addressInput = document.getElementById('address');
addressGroup.style.display = 'none';
// 添加事件监听器，当身份选择发生变化时触发
roleSelect.addEventListener('change', function(event) {
  // 获取当前选择的身份值
  const selectedRole = roleSelect.value;

  // 根据选择的身份设置用户名的显示文本
  if (selectedRole === '商家') {
    usernameInput.placeholder = '店名';
  } else {
    usernameInput.placeholder = '用户名';
  }

  // 根据选择的身份显示/隐藏地址输入框
  if (selectedRole === '商家') {
    addressGroup.style.display = 'block';
  } else {
    addressGroup.style.display = 'none';
    addressInput.value = ''; // 清空地址输入框的值
  }
});

// 获取注册表单
const registerForm = document.getElementById('register-form');

// 给表单添加 submit 事件监听器
registerForm.addEventListener('submit', function(event) {
  // 获取表单元素
  const username = usernameInput.value;
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm-password').value;
  const role = document.getElementById('role').value;

  // 判断两次密码是否相同
  if (password !== confirmPassword) {
    const passwordError = document.getElementById('password-error');
    // 阻止表单的默认提交行为
    event.preventDefault();
    passwordError.textContent = '两次输入的密码不一致';
  } else {
    // 显示注册成功的提示弹窗
    alert(`注册成功！即将跳转到登录界面`);
  }
});
