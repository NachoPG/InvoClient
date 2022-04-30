import { Component, Input, OnInit } from '@angular/core';
import { Clients } from '../../interfaces/clients.interface';

@Component({
  selector: 'app-table-clients',
  templateUrl: './table-clients.component.html',
  styleUrls: ['./table-clients.component.css'],
})
export class TableClientsComponent implements OnInit {
  @Input() clientsList: Clients[] = [];
  page: number = 1;
  pageSize: number = 10;

  searchValue: string = '';

  constructor() {}

  ngOnInit() {}
}
