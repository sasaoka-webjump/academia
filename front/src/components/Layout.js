import { Layout, Menu } from "antd";
import { Link } from "react-router-dom";

const { Header, Content, Footer } = Layout;

const LayoutComponent = (props) => {

  
  return (
    <Layout className="layout">
      <Header>
        <div className="logo" />
        <Menu theme="dark" mode="horizontal" defaultSelectedKeys={["5"]}>
          <Menu.Item key="1"><Link to="/deposit">Depósito</Link></Menu.Item>
          <Menu.Item key="2"><Link to="/withdraw">Saque</Link></Menu.Item>
          <Menu.Item key="3"><Link to="/transfer">Transferência</Link></Menu.Item>
          <Menu.Item key="4"><Link to="/transactions">Transações</Link></Menu.Item>
          <Menu.Item key="5"><Link to="/home">Home</Link></Menu.Item>
          <Menu.Item key="6"><Link to="/logout">Logout</Link></Menu.Item>
        </Menu>
      </Header>
      <Content style={{ padding: "50px 50px", height:"837px" }}>
        <div className="site-layout-content">{props.children}</div>
      </Content>
      <Footer style={{ textAlign: "center" }}>
        Academia Webjump! ©2021 Feito por Igor Sasaoka
      </Footer>
    </Layout>
  );
};

export default LayoutComponent;
