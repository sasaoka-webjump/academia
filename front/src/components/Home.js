import { React, useState, useEffect } from "react";
import Layout from "./Layout";
import { Card, Row, Col } from "antd";

import { useHistory } from "react-router-dom";

import api from "../services/api";

const Home = (props) => {
  const history = useHistory();
  const [customer, setCustomer] = useState(0);
  const [regisdtrationData, setRegistrationData] = useState(0);

  useEffect(() => {
    const token = localStorage.getItem("authToken");
    const customerId = localStorage.getItem("customerId");

    if (!token || !customerId) {
      history.push("/login");
      return <div />;
    }

    const response = api
      .get(`/api/customers/${customerId}`, {
        headers: {
          Authorization: "Basic " + token,
        },
      })
      .then((response) => {
        console.log(response.data);
        setCustomer(response.data.customer);
        setRegistrationData(response.data.regisdtrationData);
      });
  }, []);

  return (
    <Layout>
      <>
        <Row>
          <Col>
            <Card style={{ width: 300 }}>
              <p>Número da conta: {customer.accountNumber}</p>
              <p>Estado: {customer.adress_state}</p>
              <p>Cidade: {customer.adress_city}</p>
              <p>Bairro: {customer.adress_district}</p>
              <p>Rua: {customer.adress_street}</p>
              <p>Número: {customer.adress_number}</p>
              <p>Complemento: {customer.adress_complement}</p>
              <p>{customer.is_company ? "Pessoa Jurídica" : "Pessoa Física"}</p>
              <p>Telefone: {customer.phone_number}</p>
            </Card>
          </Col>
          <Col>
          {customer.is_company ? <Card style={{ width: 300, marginLeft: 300 }}>
              <p>Razão Social: {regisdtrationData?.company_name}</p>
              <p>CNPJ: {regisdtrationData?.cnpj}</p>
              <p>Registro: {regisdtrationData?.state_registration}</p>
            </Card>
             : <Card style={{ width: 300, marginLeft: 300 }}>
              <p>Nome: {regisdtrationData?.name}</p>
              <p>CPF: {regisdtrationData?.cpf}</p>
              <p>RG: {regisdtrationData?.national_identity_card}</p>
            </Card>}
            
          </Col>
        </Row>
      </>
    </Layout>
  );
};

export default Home;
