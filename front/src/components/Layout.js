import { Layout, Menu, } from 'antd';

const { Header, Content, Footer } = Layout;

const LayoutComponent = (props) => (
  <Layout className="layout">
    <Header>
      <div className="logo" />
      <Menu theme="dark" mode="horizontal" defaultSelectedKeys={['2']}>
        <Menu.Item key="1">nav 1</Menu.Item>
        <Menu.Item key="2">nav 2</Menu.Item>
        <Menu.Item key="3">nav 3</Menu.Item>
      </Menu>
    </Header>
    <Content style={{ padding: '50px 50px' }}>
      <div className="site-layout-content">
        {props.children}
      </div>
    </Content>
    <Footer style={{ textAlign: 'center' }}>Academia Webjump! ©2021 Feito por Igor Sasaoka</Footer>
  </Layout>
);


export default LayoutComponent;