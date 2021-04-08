import React, { useEffect, useState } from "react";
import Layout from "./Layout";
import { Form, Alert, Button, InputNumber } from "antd";

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

const Withdraw = () => {
  const history = useHistory();
  const token = localStorage.getItem("authToken");

  useEffect(() => {

    if (!token) {
      history.push("/login");
      return <div />;
    }
  }, []);

  const [visible, setVisible] = useState(false);
  const [errorVisible, setErrorVisible] = useState(false);
  const handleClose = () => {
    setVisible(false);
    setErrorVisible(false);
  };

  const onFinish = async (values) => {
    try {
      const response = await api.post(
        "/api/customer/withdraw",
        {
          value: values.value,
        },
        {
          headers: {
            Authorization: "Basic " + token,
          },
        }
      );

      setVisible(true);
      console.log(response.data);
    } catch (error) {
      setErrorVisible(true);
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
            label="Valor"
            name="value"
            rules={[
              {
                required: true,
                message: "Digite o valor a ser sacado",
              },
            ]}
          >
            <InputNumber min={1} defaultValue={0} />
          </Form.Item>

          <Form.Item {...tailLayout}>
            <Button type="primary" htmlType="submit">
              Sacar
            </Button>
          </Form.Item>
        </Form>
      </div>
      <div>
        {visible ? (
          <Alert
            message="Depósito realizado com sucesso"
            type="success"
            closable
            afterClose={handleClose}
          />
        ) : null}
      </div>
      <div>
        {errorVisible  ? (
          <Alert
            message="Saldo insuficiente"
            type="error"
            closable
            afterClose={handleClose}
          />
        ) : null}
      </div>
    </Layout>
  );
};

export default Withdraw;
