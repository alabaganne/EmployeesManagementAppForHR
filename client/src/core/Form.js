import Errors from "./Errors";
import axios from "axios";

export default class Form {
  constructor(data) {
    this.originalData = data;

    for (let field in data) {
      this[field] = data[field];
    }

    this.errors = new Errors();
  }

  data() {
    let data = {};

    for (let field in this.originalData) {
      data[field] = this[field];
    }

    return data;
  }

  clear() {
    for(let field in this.originalData) {
      this[field] = '';
    }
  }

  post(url) {
    return this.submit("post", url);
  }

  submit(requestType, url) {
    return new Promise((resolve, reject) => {
      axios[requestType](url, this.data())
        .then((response) => {
          resolve(response);
        })
        .catch((errors) => {
          if (errors.response.data.errors) {
            this.errors.record(errors.response.data.errors);
          }
          reject(errors.response);
        });
    });
  }
}
