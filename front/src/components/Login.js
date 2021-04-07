import React from "react";
import Layout from "./Layout";
import { Form, Input, Button, Checkbox } from "antd";

import { useHistory } from "react-router-dom";

import api from "../services/api";

const layout = {
  labelCol: {
    span: 8,
  },
  wrapperCol: {
    span: 8,
  },
};
const tailLayout = {
  wrapperCol: {
    offset: 8,
    span: 16,
  },
};

const Login = () => {

  const history = useHistory();
  const onFinish = async (values) => {
    try {
      const response = await api.post("/login", {
        accountNumber: values.accountNumber,
        password: values.password,
      });
  
      localStorage.setItem("authToken", response.data.token);
      localStorage.setItem("customerId", response.data.customerId);
  
      history.push('/home');
    } catch (error) {
    console.log("Failed:", error);

    }
    
  };

  const onFinishFailed = (errorInfo) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <Layout>
      <div>
        <Form
          {...layout}
          name="basic"
          initialValues={{
            remember: true,
          }}
          onFinish={onFinish}
          onFinishFailed={onFinishFailed}
        >
          <Form.Item
            label="Account Number"
            name="accountNumber"
            rules={[
              {
                required: true,
                message: "Please input your Account Number!",
              },
            ]}
          >
            <Input />
          </Form.Item>

          <Form.Item
            label="Password"
            name="password"
            rules={[
              {
                required: true,
                message: "Please input your password!",
              },
            ]}
          >
            <Input.Password />
          </Form.Item>

          <Form.Item {...tailLayout} name="remember" valuePropName="checked">
            <Checkbox>Remember me</Checkbox>
          </Form.Item>

          <Form.Item {...tailLayout}>
            <Button type="primary" htmlType="submit">
              Submit
            </Button>
          </Form.Item>
        </Form>
      </div>
    </Layout>
  );
};

export default Login;
