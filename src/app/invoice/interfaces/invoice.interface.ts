export interface Invoice {
  idInvoice: string;
  nameArticle: string;
  price_unit: number;
  price_total: number;
  description: string;
  amount: number;
  order_date: Date;
  idClient?: number;
}
