import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClientRoutingModule } from './client-routing.module';
import { ClientComponent } from './pages/main-page-client/client.component';
import { TableClientsComponent } from './components/table-clients/table-clients.component';
import { NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { FormsModule } from '@angular/forms';
import { SearchFilterPipe } from './pipes/search-filter.pipe';

@NgModule({
  declarations: [ClientComponent, TableClientsComponent, SearchFilterPipe],
  imports: [
    CommonModule,
    ClientRoutingModule,
    NgbPaginationModule,
    FormsModule,
    
  ],
})
export class ClientModule {}
