import React, { useEffect } from "react";
import Layout from "./Layout";
import { Form, Input, Button, InputNumber } from "antd";

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

const Transfer = () => {
  const history = useHistory();
  const token = localStorage.getItem("authToken");

  useEffect(() => {

    if (!token) {
      history.push("/login");
      return <div />;
    }
  }, []);

  const onFinish = async (values) => {
    try {
      const response = await api.post(
        `/api/customer/transfer/${values.accountNumber}`,
        {
          value: values.value,
        },
        {
          headers: {
            Authorization: "Basic " + token,
          },
        }
      );

      console.log(response.data);
    } catch (error) {
      console.log("Failed:", error.body);
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
            label="Valor"
            name="value"
            rules={[
              {
                required: true,
                message: "Digite o valor a ser depositado",
              },
            ]}
          >
            <InputNumber min={1} defaultValue={0} />
          </Form.Item>

          <Form.Item
            label="Número da conta destino"
            name="accountNumber"
            rules={[
              {
                required: true,
                message: "Digite o número da conta destino",
              },
            ]}
          >
            <Input/>
          </Form.Item>

          <Form.Item {...tailLayout}>
            <Button type="primary" htmlType="submit">
              Depositar
            </Button>
          </Form.Item>
        </Form>
      </div>
    </Layout>
  );
};

export default Transfer;
