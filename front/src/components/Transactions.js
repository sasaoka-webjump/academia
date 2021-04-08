import { React, useState, useEffect } from "react";
import Layout from "./Layout";
import { Table } from "antd";

import { useHistory } from "react-router-dom";

import api from "../services/api";



const columns = [
  {
    title: "Tipo",
    dataIndex: "type",
    key: "type",
  },
  {
    title: "Valor",
    dataIndex: "value",
    key: "value",
  },
  {
    title: "Destino",
    dataIndex: "destination",
    key: "destination",
  },
  {
    title: "Data",
    dataIndex: "created_at",
    key: "created_at",
  },
];

const Transactions = (props) => {
  const history = useHistory();
  const [transactions, setTransactions] = useState(0);
  
  useEffect(() => {
    const token = localStorage.getItem("authToken");
    const customerId = localStorage.getItem("customerId");

    if (!token || !customerId) {
      history.push("/login");
      return <div />;
    }

    const response = api
      .get(`/api/customer/transactions`, {
        headers: {
          Authorization: "Basic " + token,
        },
      })
      .then((response) => {
        let array = eval(response.data.transactions);
        console.log(array);
        setTransactions(array.map(function(transaction){
          let type;
          if (transaction.type === "withdraw") type = "Saque";
          if (transaction.type === "deposit") type = "Deposito";
          if (transaction.type === "transfer") type = "Transferencia";
          
          return {
            type,
            value: transaction.value,
            destination: transaction.destination_customer_id,
            created_at: transaction.created_at
          }
        }));
      });
  }, []);

  return (
    <Layout>
      <Table dataSource={transactions} columns={columns} />;
    </Layout>
  );
};

export default Transactions;
